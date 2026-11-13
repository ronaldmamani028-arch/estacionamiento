@extends('adminlte::page')

@section('title', 'Entradas')

@section('content_header')
    <h1>Entradas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formBuscar" class="form-inline">
                <label class="mr-2">Placa</label>
                <input type="text" id="buscarPlaca" class="form-control mr-2" placeholder="Ej. 1234ABC"
                    autocomplete="off" style="text-transform: uppercase;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar y registrar entrada
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Vehículos en el estacionamiento</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaEntradas">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Placa</th>
                        <th>Tipo</th>
                        <th>Espacio</th>
                        <th>Hora de entrada</th>
                        <th>Abonado</th>
                        <th>Registró</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('entradas.formulario')

    <div class="modal fade" id="modalTicket" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ticket de entrada</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="iframeTicket" style="width: 100%; height: 500px; border: 0;"></iframe>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/pagos.js') }}"></script>
    <script src="{{ asset('js/entradas.js') }}"></script>
@stop
