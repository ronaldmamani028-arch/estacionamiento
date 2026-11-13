@extends('reportes.exportar.plantilla')

@section('titulo', 'Ocupación actual (espacios activos)')

@section('contenido')
    <table>
        <thead>
            <tr>
                <th>Piso</th>
                <th>Sector</th>
                <th>Espacios</th>
                <th>Ocupados</th>
                <th>Libres</th>
                <th>% ocupación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sectores as $s)
                <tr>
                    <td>Piso {{ $s->piso }}</td>
                    <td>{{ $s->sector }}</td>
                    <td class="derecha">{{ $s->total }}</td>
                    <td class="derecha">{{ $s->ocupados }}</td>
                    <td class="derecha">{{ $s->libres }}</td>
                    <td class="derecha">{{ $s->porcentaje }} %</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total</th>
                <th class="derecha">{{ $total }}</th>
                <th class="derecha">{{ $ocupados }}</th>
                <th class="derecha">{{ $libres }}</th>
                <th class="derecha">{{ $porcentaje }} %</th>
            </tr>
        </tfoot>
    </table>
@endsection
