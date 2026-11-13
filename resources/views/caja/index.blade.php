@extends('adminlte::page')

@section('title', 'Caja')

@section('content_header')
    <h1>Caja</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formFiltro" class="form-inline">
                <label class="mr-2">Desde</label>
                <input type="date" id="desde" class="form-control mr-3" value="{{ date('Y-m-d') }}">
                <label class="mr-2">Hasta</label>
                <input type="date" id="hasta" class="form-control mr-3" value="{{ date('Y-m-d') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Bs <span id="totalEfectivo">0.00</span></h3>
                    <p>Efectivo</p>
                </div>
                <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Bs <span id="totalQr">0.00</span></h3>
                    <p>QR Yape</p>
                </div>
                <div class="icon"><i class="fas fa-qrcode"></i></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>Bs <span id="totalGeneral">0.00</span></h3>
                    <p>Total general</p>
                </div>
                <div class="icon"><i class="fas fa-cash-register"></i></div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Boletos cobrados</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaBoletos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Placa</th>
                        <th>Fecha y hora</th>
                        <th>Método</th>
                        <th>N° operación</th>
                        <th>Monto (Bs)</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mensualidades cobradas</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaMensualidades">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha y hora</th>
                        <th>Período</th>
                        <th>Método</th>
                        <th>N° operación</th>
                        <th>Monto (Bs)</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/caja.js') }}"></script>
@stop
