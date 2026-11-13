<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('usuarios.index', compact('roles'));
    }

    public function listar()
    {
        $usuarios = User::with('rol')->get();
        return response()->json(['success' => true, 'data' => $usuarios]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'rol_id' => $request->rol_id,
            'estado' => 1,
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario registrado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'rol_id' => 'required|exists:roles,id',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'rol_id' => $request->rol_id,
        ]);

        if ($request->filled('password')) {
            $usuario->update(['password' => $request->password]);
        }

        return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    }

    public function cambiarEstado($id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->id == Auth::id()) {
            return response()->json(['success' => false, 'message' => 'No puedes desactivar tu propio usuario'], 403);
        }

        $usuario->update(['estado' => $usuario->estado == 1 ? 0 : 1]);

        return response()->json(['success' => true, 'message' => 'Estado actualizado correctamente']);
    }
}
