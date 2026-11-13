@extends('adminlte::page')

@section('title', 'Vehículos')

@section('content_header')
    <h1>Vehículos</h1>
@stop

@section('content')
    <div class="card">
        @can('operar')
            <div class="card-header">
                <button class="btn btn-primary" id="btnNuevo">
                    <i class="fas fa-plus"></i> Nuevo vehículo
                </button>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaVehiculos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Dueño</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @can('operar')
        @include('vehiculos.formulario')
    @endcan
@stop

@section('js')
    <script>
        let puedeEditar = {{ auth()->user()->can('operar') ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/vehiculos.js') }}"></script>
@stop
