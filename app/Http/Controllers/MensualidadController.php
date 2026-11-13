<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mensualidad;
use App\Models\MetodoPago;
use App\Models\Tarifa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MensualidadController extends Controller
{
    public function index()
    {
        $tarifas = Tarifa::with('tipoVehiculo')->where('estado', 1)->get();
        $metodos = MetodoPago::all();
        return view('mensualidades.index', compact('tarifas', 'metodos'));
    }

    public function listar()
    {
        $mensualidades = Mensualidad::with('cliente', 'metodoPago', 'usuario')->orderBy('id', 'desc')->get();
        return response()->json(['success' => true, 'data' => $mensualidades]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'tarifa_id' => 'required|exists:tarifas,id',
            'metodo_pago_id' => 'required|exists:metodos_pago,id',
        ]);

        $cliente = Cliente::findOrFail($request->cliente_id);
        $tarifa = Tarifa::findOrFail($request->tarifa_id);
        $metodo = MetodoPago::findOrFail($request->metodo_pago_id);

        if ($cliente->es_abonado == 0 || $cliente->estado == 0) {
            return response()->json(['success' => false, 'message' => 'Solo se cobra la mensualidad a clientes abonados y activos.'], 403);
        }

        if ($tarifa->estado == 0) {
            return response()->json(['success' => false, 'message' => 'Esa tarifa está desactivada.'], 403);
        }

        if ($metodo->nombre == 'QR Yape') {
            $request->validate(['numero_operacion' => 'required|string|max:50']);
        } else {
            $request->validate(['monto_recibido' => 'required|numeric|min:' . $tarifa->precio_mensualidad]);
        }

        if ($cliente->fecha_vencimiento != null && $cliente->fecha_vencimiento >= date('Y-m-d')) {
            $inicio = Carbon::parse($cliente->fecha_vencimiento)->addDay();
        } else {
            $inicio = now();
        }

        $fin = $inicio->copy()->addMonthNoOverflow();

        Mensualidad::create([
            'cliente_id' => $cliente->id,
            'user_id' => Auth::id(),
            'monto' => $tarifa->precio_mensualidad,
            'fecha_inicio' => $inicio->toDateString(),
            'fecha_fin' => $fin->toDateString(),
            'metodo_pago_id' => $metodo->id,
            'numero_operacion' => $metodo->nombre == 'QR Yape' ? $request->numero_operacion : null,
        ]);

        $cliente->fecha_vencimiento = $fin->toDateString();
        $cliente->save();

        return response()->json(['success' => true, 'message' => 'Mensualidad cobrada. Vigente hasta el ' . $fin->format('d/m/Y') . '.']);
    }
}
