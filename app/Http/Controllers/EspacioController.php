<?php

namespace App\Http\Controllers;

use App\Models\Espacio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EspacioController extends Controller
{
    public function index()
    {
        return view('espacios.index');
    }

    public function mapa()
    {
        return view('espacios.mapa');
    }

    public function listar()
    {
        $espacios = Espacio::with('boletoAbierto.vehiculo')->orderBy('piso')->orderBy('sector')->orderBy('numero')->get();
        return response()->json(['success' => true, 'data' => $espacios]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'piso' => 'required|integer|min:1|max:20',
            'sector' => 'required|alpha_num|max:5',
            'numero' => [
                'required', 'integer', 'min:1', 'max:999',
                Rule::unique('espacios')->where('piso', $request->piso)->where('sector', $request->sector),
            ],
        ]);

        Espacio::create([
            'piso' => $request->piso,
            'sector' => strtoupper($request->sector),
            'numero' => $request->numero,
            'esta_ocupado' => 0,
            'estado' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Espacio registrado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'piso' => 'required|integer|min:1|max:20',
            'sector' => 'required|alpha_num|max:5',
            'numero' => [
                'required', 'integer', 'min:1', 'max:999',
                Rule::unique('espacios')->where('piso', $request->piso)->where('sector', $request->sector)->ignore($id),
            ],
        ]);

        $espacio = Espacio::findOrFail($id);
        $espacio->update([
            'piso' => $request->piso,
            'sector' => strtoupper($request->sector),
            'numero' => $request->numero,
        ]);

        return response()->json(['success' => true, 'message' => 'Espacio actualizado correctamente']);
    }

    public function cambiarEstado($id)
    {
        $espacio = Espacio::findOrFail($id);

        if ($espacio->estado == 1 && $espacio->esta_ocupado == 1) {
            return response()->json(['success' => false, 'message' => 'No se puede desactivar un espacio ocupado'], 403);
        }

        $espacio->update(['estado' => $espacio->estado == 1 ? 0 : 1]);

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
