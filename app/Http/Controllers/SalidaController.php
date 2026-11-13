<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\MetodoPago;
use App\Models\Tarifa;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SalidaController extends Controller
{
    public function index()
    {
        $metodos = MetodoPago::all();
        return view('salidas.index', compact('metodos'));
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'buscar' => 'required|string|max:20',
        ]);

        $texto = strtoupper($request->buscar);

        $boleto = Boleto::where('codigo', $texto)->whereNull('hora_salida')->first();

        if (!$boleto) {
            $vehiculo = Vehiculo::where('placa', $texto)->first();
            if ($vehiculo) {
                $boleto = $vehiculo->boletoAbierto;
            }
        }

        if (!$boleto) {
            return response()->json(['success' => false, 'message' => 'No hay un vehículo adentro con ese código o placa.'], 404);
        }

        $boleto->load('vehiculo.tipoVehiculo', 'espacio');

        $tarifa = Tarifa::where('tipo_vehiculo_id', $boleto->vehiculo->tipo_vehiculo_id)->first();
        $totalMinutos = (int) $boleto->hora_entrada->diffInMinutes(now());
        $precioFraccion = round($tarifa->precio_hora * $tarifa->minutos_fraccion / 60, 2);
        $fracciones = (int) max(1, ceil($totalMinutos / $tarifa->minutos_fraccion));
        $monto = $fracciones * $precioFraccion;

        if ($boleto->es_abonado == 1) {
            $monto = 0;
        }

        return response()->json([
            'success' => true,
            'boleto' => $boleto,
            'tarifa' => $tarifa,
            'hora_salida' => now()->format('d/m/Y H:i'),
            'total_minutos' => $totalMinutos,
            'fracciones' => $fracciones,
            'precio_fraccion' => number_format($precioFraccion, 2, '.', ''),
            'monto' => number_format($monto, 2, '.', ''),
        ]);
    }

    public function cobrar(Request $request, $id)
    {
        $boleto = Boleto::with('vehiculo', 'espacio')->findOrFail($id);

        if ($boleto->hora_salida != null) {
            return response()->json(['success' => false, 'message' => 'Este boleto ya fue cobrado.'], 403);
        }

        $horaSalida = now();
        $tarifa = Tarifa::where('tipo_vehiculo_id', $boleto->vehiculo->tipo_vehiculo_id)->first();
        $totalMinutos = (int) $boleto->hora_entrada->diffInMinutes($horaSalida);
        $precioFraccion = round($tarifa->precio_hora * $tarifa->minutos_fraccion / 60, 2);
        $fracciones = (int) max(1, ceil($totalMinutos / $tarifa->minutos_fraccion));
        $monto = $fracciones * $precioFraccion;

        if ($boleto->es_abonado == 1) {
            $monto = 0;
        }

        $total = number_format($monto, 2, '.', '');

        if ($total != $request->monto_mostrado) {
            return response()->json(['success' => false, 'message' => 'Pasó el tiempo y el total cambió a Bs ' . $total . '. Vuelve a buscar el boleto.'], 403);
        }

        $metodoId = null;
        $numeroOperacion = null;

        if ($monto > 0) {
            $request->validate([
                'metodo_pago_id' => 'required|exists:metodos_pago,id',
            ]);
            $metodo = MetodoPago::find($request->metodo_pago_id);

            if ($metodo->nombre == 'QR Yape') {
                $request->validate(['numero_operacion' => 'required|string|max:50']);
                $numeroOperacion = $request->numero_operacion;
            } else {
                $request->validate(['monto_recibido' => 'required|numeric|min:' . $total]);
            }

            $metodoId = $metodo->id;
        }

        $boleto->update([
            'hora_salida' => $horaSalida,
            'total_minutos' => $totalMinutos,
            'monto_total' => $total,
            'metodo_pago_id' => $metodoId,
            'numero_operacion' => $numeroOperacion,
            'esta_pagado' => 1,
        ]);

        $boleto->espacio->update(['esta_ocupado' => 0]);

        return response()->json(['success' => true, 'message' => 'Salida registrada: ' . $boleto->codigo, 'id' => $boleto->id]);
    }

    public function comprobante($id)
    {
        $boleto = Boleto::with('vehiculo.tipoVehiculo', 'espacio', 'metodoPago')->whereNotNull('hora_salida')->findOrFail($id);

        $pdf = Pdf::loadView('salidas.comprobante', compact('boleto'));
        $pdf->setPaper([0, 0, 226.77, 283.46]);

        return $pdf->stream('comprobante-' . $boleto->codigo . '.pdf');
    }
}
