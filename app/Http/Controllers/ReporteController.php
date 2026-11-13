<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\Boleto;
use App\Models\Espacio;
use App\Models\Mensualidad;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function ingresos(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
            'agrupar' => 'required|in:dia,mes',
        ]);

        $formato = $request->agrupar == 'mes' ? '%Y-%m' : '%Y-%m-%d';

        $boletos = Boleto::selectRaw('DATE_FORMAT(hora_salida, ?) as periodo, SUM(monto_total) as total', [$formato])
            ->where('esta_pagado', 1)
            ->where('monto_total', '>', 0)
            ->whereDate('hora_salida', '>=', $request->desde)
            ->whereDate('hora_salida', '<=', $request->hasta)
            ->groupBy('periodo')
            ->get()
            ->keyBy('periodo');

        $mensualidades = Mensualidad::selectRaw('DATE_FORMAT(created_at, ?) as periodo, SUM(monto) as total', [$formato])
            ->whereDate('created_at', '>=', $request->desde)
            ->whereDate('created_at', '<=', $request->hasta)
            ->groupBy('periodo')
            ->get()
            ->keyBy('periodo');

        $periodos = $boletos->keys()->merge($mensualidades->keys())->unique()->sort();

        $filas = [];
        foreach ($periodos as $periodo) {
            $montoBoletos = $boletos[$periodo]->total ?? 0;
            $montoMensualidades = $mensualidades[$periodo]->total ?? 0;

            $filas[] = [
                'periodo' => $periodo,
                'boletos' => number_format($montoBoletos, 2, '.', ''),
                'mensualidades' => number_format($montoMensualidades, 2, '.', ''),
                'total' => number_format($montoBoletos + $montoMensualidades, 2, '.', ''),
            ];
        }

        $totalBoletos = number_format($boletos->sum('total'), 2, '.', '');
        $totalMensualidades = number_format($mensualidades->sum('total'), 2, '.', '');
        $totalGeneral = number_format($boletos->sum('total') + $mensualidades->sum('total'), 2, '.', '');

        $datos = compact('filas', 'totalBoletos', 'totalMensualidades', 'totalGeneral');

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.exportar.ingresos', $datos);
            return $pdf->stream('reporte-ingresos.pdf');
        }

        if ($request->formato == 'excel') {
            return Excel::download(new ReporteExport('reportes.exportar.ingresos', $datos), 'reporte-ingresos.xlsx');
        }

        return response()->json([
            'success' => true,
            'data' => $filas,
            'total_boletos' => $totalBoletos,
            'total_mensualidades' => $totalMensualidades,
            'total_general' => $totalGeneral,
        ]);
    }

    public function frecuentes(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $vehiculos = Boleto::selectRaw('vehiculo_id, COUNT(*) as entradas')
            ->with('vehiculo.tipoVehiculo', 'vehiculo.cliente')
            ->whereDate('hora_entrada', '>=', $request->desde)
            ->whereDate('hora_entrada', '<=', $request->hasta)
            ->groupBy('vehiculo_id')
            ->orderByDesc('entradas')
            ->orderBy('vehiculo_id')
            ->limit(10)
            ->get();

        $datos = compact('vehiculos');

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.exportar.frecuentes', $datos);
            return $pdf->stream('reporte-vehiculos-frecuentes.pdf');
        }

        if ($request->formato == 'excel') {
            return Excel::download(new ReporteExport('reportes.exportar.frecuentes', $datos), 'reporte-vehiculos-frecuentes.xlsx');
        }

        return response()->json(['success' => true, 'data' => $vehiculos]);
    }

    public function ocupacion(Request $request)
    {
        $request->validate([
            'desde' => 'required|date',
            'hasta' => 'required|date|after_or_equal:desde',
        ]);

        $dias = Boleto::selectRaw('DATE(hora_entrada) as fecha, COUNT(*) as entradas')
            ->whereDate('hora_entrada', '>=', $request->desde)
            ->whereDate('hora_entrada', '<=', $request->hasta)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $totalEntradas = $dias->sum('entradas');

        $datos = compact('dias', 'totalEntradas');

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.exportar.ocupacion', $datos);
            return $pdf->stream('reporte-ocupacion.pdf');
        }

        if ($request->formato == 'excel') {
            return Excel::download(new ReporteExport('reportes.exportar.ocupacion', $datos), 'reporte-ocupacion.xlsx');
        }

        return response()->json([
            'success' => true,
            'data' => $dias,
            'total_entradas' => $totalEntradas,
        ]);
    }

    public function ocupacionActual(Request $request)
    {
        $sectores = Espacio::selectRaw('piso, sector, COUNT(*) as total, SUM(esta_ocupado) as ocupados')
            ->where('estado', 1)
            ->groupBy('piso', 'sector')
            ->orderBy('piso')
            ->orderBy('sector')
            ->get();

        foreach ($sectores as $s) {
            $s->ocupados = (int) $s->ocupados;
            $s->libres = $s->total - $s->ocupados;
            $s->porcentaje = round($s->ocupados * 100 / $s->total);
        }

        $total = $sectores->sum('total');
        $ocupados = $sectores->sum('ocupados');
        $libres = $total - $ocupados;
        $porcentaje = $total > 0 ? round($ocupados * 100 / $total) : 0;

        $datos = compact('sectores', 'total', 'ocupados', 'libres', 'porcentaje');

        if ($request->formato == 'pdf') {
            $pdf = Pdf::loadView('reportes.exportar.ocupacion_actual', $datos);
            return $pdf->stream('reporte-ocupacion-actual.pdf');
        }

        if ($request->formato == 'excel') {
            return Excel::download(new ReporteExport('reportes.exportar.ocupacion_actual', $datos), 'reporte-ocupacion-actual.xlsx');
        }

        return response()->json([
            'success' => true,
            'data' => $sectores,
            'total' => $total,
            'ocupados' => $ocupados,
            'libres' => $libres,
            'porcentaje' => $porcentaje,
        ]);
    }
}
