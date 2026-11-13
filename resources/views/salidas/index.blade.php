@extends('adminlte::page')

@section('title', 'Salidas')

@section('content_header')
    <h1>Salidas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formBuscar" class="form-inline">
                <label class="mr-2">Código del boleto o placa</label>
                <input type="text" id="buscarBoleto" class="form-control mr-2" placeholder="Ej. B-000001 o 1234ABC"
                    autocomplete="off" style="text-transform: uppercase;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Buscar y cobrar
                </button>
            </form>
        </div>
    </div>

    @include('salidas.formulario')

    <div class="modal fade" id="modalComprobante" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comprobante de salida</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body p-0">
                    <iframe id="iframeComprobante" style="width: 100%; height: 500px; border: 0;"></iframe>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/pagos.js') }}"></script>
    <script src="{{ asset('js/salidas.js') }}"></script>
@stop
