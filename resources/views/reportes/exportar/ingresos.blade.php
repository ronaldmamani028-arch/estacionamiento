@extends('reportes.exportar.plantilla')

@section('titulo', request('agrupar') == 'mes' ? 'Ingresos por mes' : 'Ingresos por día')

@section('contenido')
    <p>Del {{ date('d/m/Y', strtotime(request('desde'))) }} al {{ date('d/m/Y', strtotime(request('hasta'))) }}</p>

    <table>
        <thead>
            <tr>
                <th>Período</th>
                <th>Boletos (Bs)</th>
                <th>Mensualidades (Bs)</th>
                <th>Total (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($filas as $fila)
                <tr>
                    <td>{{ implode('/', array_reverse(explode('-', $fila['periodo']))) }}</td>
                    <td class="derecha" data-format="0.00">{{ $fila['boletos'] }}</td>
                    <td class="derecha" data-format="0.00">{{ $fila['mensualidades'] }}</td>
                    <td class="derecha" data-format="0.00">{{ $fila['total'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay ingresos en estas fechas.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="derecha" data-format="0.00">{{ $totalBoletos }}</th>
                <th class="derecha" data-format="0.00">{{ $totalMensualidades }}</th>
                <th class="derecha" data-format="0.00">{{ $totalGeneral }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
