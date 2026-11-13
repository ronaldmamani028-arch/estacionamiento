@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <div class="card">
        @can('operar')
            <div class="card-header">
                <button class="btn btn-primary" id="btnNuevo">
                    <i class="fas fa-plus"></i> Nuevo cliente
                </button>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaClientes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>CI</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Abonado</th>
                        <th>Vence</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @can('operar')
        @include('clientes.formulario')
    @endcan
@stop

@section('js')
    <script>
        let puedeEditar = {{ auth()->user()->can('operar') ? 'true' : 'false' }};
    </script>
    <script src="{{ asset('js/clientes.js') }}"></script>
@stop
