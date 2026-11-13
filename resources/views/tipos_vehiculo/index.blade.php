@extends('adminlte::page')

@section('title', 'Tipos de vehículo')

@section('content_header')
    <h1>Tipos de vehículo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo tipo
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaTipos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('tipos_vehiculo.formulario')
@stop

@section('js')
    <script src="{{ asset('js/tipos_vehiculo.js') }}"></script>
@stop
