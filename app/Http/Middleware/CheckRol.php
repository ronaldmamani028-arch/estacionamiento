<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRol
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $usuario = Auth::user();

        if ($usuario->estado == 0) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Tu usuario está desactivado.');
        }

        if (!in_array($usuario->rol->nombre, $roles)) {
            abort(403, 'No tienes permiso para entrar a esta página.');
        }

        return $next($request);
    }
}
