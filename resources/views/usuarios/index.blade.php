@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button class="btn btn-primary" id="btnNuevo">
                <i class="fas fa-plus"></i> Nuevo usuario
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tablaUsuarios">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    @include('usuarios.formulario')
@stop

@section('js')
    <script src="{{ asset('js/usuarios.js') }}"></script>
@stop
