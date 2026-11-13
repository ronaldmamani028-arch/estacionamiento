@extends('reportes.exportar.plantilla')

@section('titulo', 'Ocupación histórica (entradas por día)')

@section('contenido')
    <p>Del {{ date('d/m/Y', strtotime(request('desde'))) }} al {{ date('d/m/Y', strtotime(request('hasta'))) }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Entradas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dias as $d)
                <tr>
                    <td>{{ date('d/m/Y', strtotime($d->fecha)) }}</td>
                    <td class="derecha">{{ $d->entradas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No hay entradas en estas fechas.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th class="derecha">{{ $totalEntradas }}</th>
            </tr>
        </tfoot>
    </table>
@endsection
