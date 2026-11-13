<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Espacio;
use App\Models\Mensualidad;
use App\Models\MetodoPago;
use App\Models\Tarifa;
use App\Models\TipoVehiculo;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntradaController extends Controller
{
    public function index()
    {
        $tipos = TipoVehiculo::all();
        $metodos = MetodoPago::all();
        return view('entradas.index', compact('tipos', 'metodos'));
    }

    public function listar()
    {
        $boletos = Boleto::with('vehiculo.tipoVehiculo', 'espacio', 'usuario')
            ->whereNull('hora_salida')
            ->orderBy('hora_entrada', 'desc')
            ->get();

        return response()->json(['success' => true, 'data' => $boletos]);
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'placa' => 'required|alpha_num|max:15',
        ]);

        $placa = strtoupper($request->placa);
        $vehiculo = Vehiculo::with('cliente', 'tipoVehiculo')->where('placa', $placa)->first();

        if (!$vehiculo) {
            return response()->json(['success' => true, 'existe' => false, 'placa' => $placa]);
        }

        if ($vehiculo->estado == 0) {
            return response()->json(['success' => false, 'message' => 'El vehículo ' . $placa . ' está desactivado: no puede entrar.'], 403);
        }

        if ($vehiculo->boletoAbierto) {
            return response()->json(['success' => false, 'message' => 'El vehículo ' . $placa . ' ya está adentro (boleto ' . $vehiculo->boletoAbierto->codigo . ').'], 403);
        }

        $tarifa = Tarifa::where('tipo_vehiculo_id', $vehiculo->tipo_vehiculo_id)->where('estado', 1)->first();
        if (!$tarifa) {
            return response()->json(['success' => false, 'message' => 'Este tipo de vehículo no tiene una tarifa activa: no puede entrar.'], 403);
        }

        $abonado = 'no';
        $cliente = $vehiculo->cliente;
        if ($cliente && $cliente->es_abonado == 1) {
            if ($cliente->fecha_vencimiento != null && $cliente->fecha_vencimiento >= date('Y-m-d')) {
                $abonado = 'vigente';
            } else {
                $abonado = 'vencido';
            }
        }

        return response()->json([
            'success' => true,
            'existe' => true,
            'placa' => $placa,
            'vehiculo' => $vehiculo,
            'abonado' => $abonado,
            'precio_mensualidad' => $tarifa->precio_mensualidad,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|alpha_num|max:15',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        $placa = strtoupper($request->placa);
        $vehiculo = Vehiculo::where('placa', $placa)->first();

        if ($vehiculo) {
            if ($vehiculo->estado == 0) {
                return response()->json(['success' => false, 'message' => 'El vehículo ' . $placa . ' está desactivado: no puede entrar.'], 403);
            }
            if ($vehiculo->boletoAbierto) {
                return response()->json(['success' => false, 'message' => 'El vehículo ' . $placa . ' ya está adentro (boleto ' . $vehiculo->boletoAbierto->codigo . ').'], 403);
            }
            $tipoId = $vehiculo->tipo_vehiculo_id;
        } else {
            $request->validate([
                'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id',
                'marca' => 'required|string|max:50',
                'modelo' => 'required|string|max:50',
                'color' => 'required|string|max:30',
            ]);
            $tipoId = $request->tipo_vehiculo_id;
        }

        $tarifa = Tarifa::where('tipo_vehiculo_id', $tipoId)->where('estado', 1)->first();
        if (!$tarifa) {
            return response()->json(['success' => false, 'message' => 'Este tipo de vehículo no tiene una tarifa activa: no puede entrar.'], 403);
        }

        $cliente = $vehiculo ? $vehiculo->cliente : null;
        $esAbonado = 0;
        $cobrarMensualidad = false;

        if ($cliente && $cliente->es_abonado == 1) {
            if ($cliente->fecha_vencimiento != null && $cliente->fecha_vencimiento >= date('Y-m-d')) {
                $esAbonado = 1;
            } elseif ($request->has('cobrar_mensualidad')) {
                $cobrarMensualidad = true;
            }
        }

        if ($cobrarMensualidad) {
            $request->validate([
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
            ]);
            $metodo = MetodoPago::find($request->metodo_pago_id);

            if ($metodo->nombre == 'QR Yape') {
                $request->validate(['numero_operacion' => 'required|string|max:50']);
            } else {
                $request->validate(['monto_recibido' => 'required|numeric|min:' . $tarifa->precio_mensualidad]);
            }
        }

        $cambiados = Espacio::where('id', $request->espacio_id)
            ->where('estado', 1)
            ->where('esta_ocupado', 0)
            ->update(['esta_ocupado' => 1]);

        if ($cambiados == 0) {
            return response()->json(['success' => false, 'message' => 'El espacio elegido ya no está libre. Elige otro.'], 403);
        }

        if (!$vehiculo) {
            $vehiculo = Vehiculo::create([
                'placa' => $placa,
                'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
                'cliente_id' => null,
                'marca' => $request->marca,
                'modelo' => $request->modelo,
                'color' => $request->color,
                'estado' => 1,
            ]);
        }

        if ($cobrarMensualidad) {
            $fechaFin = now()->addMonthNoOverflow()->toDateString();

            Mensualidad::create([
                'cliente_id' => $cliente->id,
                'user_id' => Auth::id(),
                'monto' => $tarifa->precio_mensualidad,
                'fecha_inicio' => date('Y-m-d'),
                'fecha_fin' => $fechaFin,
                'metodo_pago_id' => $metodo->id,
                'numero_operacion' => $metodo->nombre == 'QR Yape' ? $request->numero_operacion : null,
            ]);

            $cliente->fecha_vencimiento = $fechaFin;
            $cliente->save();

            $esAbonado = 1;
        }

        $boleto = Boleto::create([
            'vehiculo_id' => $vehiculo->id,
            'espacio_id' => $request->espacio_id,
            'user_id' => Auth::id(),
            'hora_entrada' => now(),
            'es_abonado' => $esAbonado,
            'esta_pagado' => 0,
        ]);

        $boleto->update(['codigo' => 'B-' . str_pad($boleto->id, 6, '0', STR_PAD_LEFT)]);

        return response()->json(['success' => true, 'message' => 'Entrada registrada: ' . $boleto->codigo, 'id' => $boleto->id]);
    }

    public function ticket($id)
    {
        $boleto = Boleto::with('vehiculo.tipoVehiculo', 'espacio', 'usuario')->findOrFail($id);

        $pdf = Pdf::loadView('entradas.ticket', compact('boleto'));
        $pdf->setPaper([0, 0, 226.77, 283.46]);

        return $pdf->stream('ticket-' . $boleto->codigo . '.pdf');
    }
}
