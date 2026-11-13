@extends('adminlte::page')

@section('title', 'Mensualidades')

@section('content_header')
    <h1>Mensualidades</h1>
@stop

@section('content')
    <div class="card">
        @can('operar')
            <div class="card-header">
                <button class="btn btn-primary" id="btnNuevo">
                    <i class="fas fa-plus"></i> Cobrar mensualidad
                </button>
            </div>
        @endcan
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaMensualidades">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha de cobro</th>
                        <th>Período</th>
                        <th>Método</th>
                        <th>N° operación</th>
                        <th>Monto (Bs)</th>
                        <th>Cobró</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @can('operar')
        @include('mensualidades.formulario')
    @endcan
@stop

@section('js')
    <script src="{{ asset('js/pagos.js') }}"></script>
    <script src="{{ asset('js/mensualidades.js') }}"></script>
@stop
