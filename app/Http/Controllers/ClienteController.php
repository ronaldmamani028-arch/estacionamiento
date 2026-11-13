<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        return view('clientes.index');
    }

    public function listar()
    {
        $clientes = Cliente::all();
        return response()->json(['success' => true, 'data' => $clientes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ci' => 'nullable|string|max:20|unique:clientes,ci',
            'telefono' => 'required|string|max:20',
            'correo_electronico' => 'nullable|email|max:100',
        ]);

        Cliente::create([
            'nombre' => $request->nombre,
            'ci' => $request->ci,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'es_abonado' => $request->has('es_abonado') ? 1 : 0,
            'estado' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Cliente registrado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ci' => 'nullable|string|max:20|unique:clientes,ci,' . $id,
            'telefono' => 'required|string|max:20',
            'correo_electronico' => 'nullable|email|max:100',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update([
            'nombre' => $request->nombre,
            'ci' => $request->ci,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'es_abonado' => $request->has('es_abonado') ? 1 : 0,
        ]);

        return response()->json(['success' => true, 'message' => 'Cliente actualizado correctamente']);
    }

    public function cambiarEstado($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update(['estado' => $cliente->estado == 1 ? 0 : 1]);

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
