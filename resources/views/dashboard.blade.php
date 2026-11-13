@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Inicio</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h4>Bienvenido, {{ auth()->user()->name }}</h4>
            <p>Rol: <b>{{ auth()->user()->rol->nombre }}</b></p>
        </div>
    </div>
@stop
