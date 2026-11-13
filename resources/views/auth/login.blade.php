@extends('adminlte::auth.auth-page', ['authType' => 'login'])

@section('auth_header', 'Inicia sesión para comenzar')

@section('auth_body')
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login.ingresar') }}" method="POST">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" value="{{ old('email') }}" class="form-control"
                   placeholder="Correo electrónico" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-envelope"></span></div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text"><span class="fas fa-lock"></span></div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            <i class="fas fa-sign-in-alt"></i> Ingresar
        </button>
    </form>
@stop
