@extends('adminlte::page')

@section('title', 'Espacios')

@section('content_header')
    <h1>Espacios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo espacio
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaEspacios">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Piso</th>
                        <th>Sector</th>
                        <th>Número</th>
                        <th>Ocupación</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('espacios.formulario')
@stop

@section('js')
    <script src="{{ asset('js/espacios.js') }}"></script>
@stop
