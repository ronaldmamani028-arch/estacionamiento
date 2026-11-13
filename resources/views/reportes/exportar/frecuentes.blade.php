@extends('reportes.exportar.plantilla')

@section('titulo', 'Vehículos más frecuentes (10 primeros)')

@section('contenido')
    <p>Del {{ date('d/m/Y', strtotime(request('desde'))) }} al {{ date('d/m/Y', strtotime(request('hasta'))) }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Placa</th>
                <th>Tipo</th>
                <th>Dueño</th>
                <th>Entradas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($vehiculos as $i => $b)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td data-type="s">{{ $b->vehiculo->placa }}</td>
                    <td data-type="s">{{ $b->vehiculo->tipoVehiculo->nombre }}</td>
                    <td data-type="s">{{ $b->vehiculo->cliente ? $b->vehiculo->cliente->nombre : '-' }}</td>
                    <td class="derecha">{{ $b->entradas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay entradas en estas fechas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
