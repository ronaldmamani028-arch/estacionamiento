<?php

namespace App\Http\Controllers;

use App\Models\Boleto;
use App\Models\Mensualidad;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    public function index()
    {
        return view('caja.index');
    }

    public function listar(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $boletos = Boleto::with('vehiculo', 'metodoPago')
            ->where('esta_pagado', 1)
            ->where('monto_total', '>', 0)
            ->whereDate('hora_salida', '>=', $request->desde)
            ->whereDate('hora_salida', '<=', $request->hasta)
            ->orderBy('hora_salida')
            ->get();

        $mensualidades = Mensualidad::with('cliente', 'metodoPago')
            ->whereDate('created_at', '>=', $request->desde)
            ->whereDate('created_at', '<=', $request->hasta)
            ->orderBy('created_at')
            ->get();

        $efectivo = $boletos->where('metodoPago.nombre', 'Efectivo')->sum('monto_total')
            + $mensualidades->where('metodoPago.nombre', 'Efectivo')->sum('monto');

        $qr = $boletos->where('metodoPago.nombre', 'QR Yape')->sum('monto_total')
            + $mensualidades->where('metodoPago.nombre', 'QR Yape')->sum('monto');

        return response()->json([
            'success' => true,
            'boletos' => $boletos,
            'mensualidades' => $mensualidades,
            'total_efectivo' => number_format($efectivo, 2, '.', ''),
            'total_qr' => number_format($qr, 2, '.', ''),
            'total_general' => number_format($efectivo + $qr, 2, '.', ''),
        ]);
    }
}
