<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoVehiculo;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function index()
    {
        $tipos = TipoVehiculo::all();
        $clientes = Cliente::orderBy('nombre')->get();
        return view('vehiculos.index', compact('tipos', 'clientes'));
    }

    public function listar()
    {
        $vehiculos = Vehiculo::with('cliente', 'tipoVehiculo')->get();
        return response()->json(['success' => true, 'data' => $vehiculos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|alpha_num|max:15|unique:vehiculos,placa',
            'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:30',
        ]);

        Vehiculo::create([
            'placa' => strtoupper($request->placa),
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'cliente_id' => $request->cliente_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'color' => $request->color,
            'estado' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Vehículo registrado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'placa' => 'required|alpha_num|max:15|unique:vehiculos,placa,' . $id,
            'tipo_vehiculo_id' => 'required|exists:tipos_vehiculo,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'marca' => 'required|string|max:50',
            'modelo' => 'required|string|max:50',
            'color' => 'required|string|max:30',
        ]);

        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update([
            'placa' => strtoupper($request->placa),
            'tipo_vehiculo_id' => $request->tipo_vehiculo_id,
            'cliente_id' => $request->cliente_id,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'color' => $request->color,
        ]);

        return response()->json(['success' => true, 'message' => 'Vehículo actualizado correctamente']);
    }

    public function cambiarEstado($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        $vehiculo->update(['estado' => $vehiculo->estado == 1 ? 0 : 1]);

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
