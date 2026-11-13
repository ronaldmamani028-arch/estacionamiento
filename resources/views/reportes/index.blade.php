@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Reportes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form id="formFiltro" class="form-inline">
                <label class="mr-2">Desde</label>
                <input type="date" id="desde" class="form-control mr-3" value="{{ date('Y-m-01') }}">
                <label class="mr-2">Hasta</label>
                <input type="date" id="hasta" class="form-control mr-3" value="{{ date('Y-m-d') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ingresos</h3>
            <div class="card-tools">
                <select id="agrupar" class="form-control form-control-sm d-inline-block w-auto">
                    <option value="dia">Por día</option>
                    <option value="mes">Por mes</option>
                </select>
                <button type="button" class="btn btn-sm btn-danger btnExportar" data-reporte="ingresos" data-formato="pdf">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
                <button type="button" class="btn btn-sm btn-success btnExportar" data-reporte="ingresos" data-formato="excel">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaIngresos">
                <thead>
                    <tr>
                        <th>Período</th>
                        <th>Boletos (Bs)</th>
                        <th>Mensualidades (Bs)</th>
                        <th>Total (Bs)</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th>Total</th>
                        <th class="text-right" id="ingresosBoletos">0.00</th>
                        <th class="text-right" id="ingresosMensualidades">0.00</th>
                        <th class="text-right" id="ingresosTotal">0.00</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Vehículos más frecuentes (10 primeros)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-danger btnExportar" data-reporte="frecuentes" data-formato="pdf">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-success btnExportar" data-reporte="frecuentes" data-formato="excel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tablaFrecuentes">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Placa</th>
                                <th>Tipo</th>
                                <th>Dueño</th>
                                <th>Entradas</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ocupación histórica (entradas por día)</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-sm btn-danger btnExportar" data-reporte="ocupacion" data-formato="pdf">
                            <i class="fas fa-file-pdf"></i> PDF
                        </button>
                        <button type="button" class="btn btn-sm btn-success btnExportar" data-reporte="ocupacion" data-formato="excel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped" id="tablaOcupacion">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Entradas</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-right" id="totalEntradas">0</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ocupación actual (espacios activos)</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-danger btnExportar" data-reporte="ocupacion-actual" data-formato="pdf">
                    <i class="fas fa-file-pdf"></i> PDF
                </button>
                <button type="button" class="btn btn-sm btn-success btnExportar" data-reporte="ocupacion-actual" data-formato="excel">
                    <i class="fas fa-file-excel"></i> Excel
                </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaOcupacionActual">
                <thead>
                    <tr>
                        <th>Piso</th>
                        <th>Sector</th>
                        <th>Espacios</th>
                        <th>Ocupados</th>
                        <th>Libres</th>
                        <th>% ocupación</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="2">Total</th>
                        <th class="text-right" id="actualTotal">0</th>
                        <th class="text-right" id="actualOcupados">0</th>
                        <th class="text-right" id="actualLibres">0</th>
                        <th class="text-right" id="actualPorcentaje">0 %</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('js/reportes.js') }}"></script>
@stop
