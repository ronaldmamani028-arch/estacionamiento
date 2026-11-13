@extends('adminlte::page')

@section('title', 'Espacios en tiempo real')

@section('content_header')
    <h1>Espacios en tiempo real</h1>
@stop

@section('content')
    <p>
        <span class="badge badge-success">Libre</span>
        <span class="badge badge-danger">Ocupado</span>
        <span class="badge badge-secondary">Inactivo</span>
        <small class="text-muted ml-2">
            Se actualiza solo cada 10 segundos. Última actualización: <span id="horaActualizacion">-</span>
        </small>
    </p>

    <div id="mapaEspacios"></div>
@stop

@section('js')
    <script src="{{ asset('js/espacios_mapa.js') }}"></script>
@stop
