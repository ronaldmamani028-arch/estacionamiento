<?php

namespace App\Http\Controllers;

use App\Models\Tarifa;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;

class TarifaController extends Controller
{
    public function index()
    {
        $tipos = TipoVehiculo::all();
        return view('tarifas.index', compact('tipos'));
    }

    public function listar()
    {
        $tarifas = Tarifa::with('tipoVehiculo')->get();
        return response()->json(['success' => true, 'data' => $tarifas]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id|unique:tarifas,tipo_vehiculo_id',
            'precio_hora' => 'required|numeric|min:0.01|max:99999.99',
            'minutos_fraccion' => 'required|integer|min:1|max:60',
            'precio_mensualidad' => 'required|numeric|min:0.01|max:99999.99',
        ]);

        Tarifa::create([
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'precio_hora' => $request->precio_hora,
            'minutos_fraccion' => $request->minutos_fraccion,
            'precio_mensualidad' => $request->precio_mensualidad,
            'estado' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Tarifa registrada correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id|unique:tarifas,tipo_vehiculo_id,' . $id,
            'precio_hora' => 'required|numeric|min:0.01|max:99999.99',
            'minutos_fraccion' => 'required|integer|min:1|max:60',
            'precio_mensualidad' => 'required|numeric|min:0.01|max:99999.99',
        ]);

        $tarifa = Tarifa::findOrFail($id);
        $tarifa->update([
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'precio_hora' => $request->precio_hora,
            'minutos_fraccion' => $request->minutos_fraccion,
            'precio_mensualidad' => $request->precio_mensualidad,
        ]);

        return response()->json(['success' => true, 'message' => 'Tarifa actualizada correctamente']);
    }

    public function cambiarEstado($id)
    {
        $tarifa = Tarifa::findOrFail($id);
        $tarifa->update(['estado' => $tarifa->estado == 1 ? 0 : 1]);

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
