@extends('adminlte::page')

@section('title', 'Tarifas')

@section('content_header')
    <h1>Tarifas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nueva tarifa
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaTarifas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo de vehículo</th>
                        <th>Precio por hora</th>
                        <th>Fracción (min)</th>
                        <th>Mensualidad</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('tarifas.formulario')
@stop

@section('js')
    <script src="{{ asset('js/tarifas.js') }}"></script>
@stop
