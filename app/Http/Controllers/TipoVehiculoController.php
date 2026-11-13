<?php

namespace App\Http\Controllers;

use App\Models\TipoVehiculo;
use Illuminate\Http\Request;

class TipoVehiculoController extends Controller
{
    public function index()
    {
        return view('tipos_vehiculo.index');
    }

    public function listar()
    {
        $tipos = TipoVehiculo::all();
        return response()->json(['success' => true, 'data' => $tipos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:tipos_vehiculo,nombre',
        ]);

        TipoVehiculo::create([
            'nombre' => $request->nombre,
        ]);

        return response()->json(['success' => true, 'message' => 'Tipo de vehículo registrado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:tipos_vehiculo,nombre,' . $id,
        ]);

        $tipo = TipoVehiculo::findOrFail($id);
        $tipo->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json(['success' => true, 'message' => 'Tipo de vehículo actualizado correctamente']);
    }
}
