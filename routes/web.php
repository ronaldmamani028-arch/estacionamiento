<?php

use App\Http\Controllers\CajaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntradaController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MensualidadController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\TarifaController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VehiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/login', [LoginController::class, 'mostrarLogin'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.ingresar')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::middleware('rol:Administrador,Operador/Cajero,Supervisor')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
        Route::get('/clientes/listar', [ClienteController::class, 'listar'])->name('clientes.listar');

        Route::get('/vehiculos', [VehiculoController::class, 'index'])->name('vehiculos.index');
        Route::get('/vehiculos/listar', [VehiculoController::class, 'listar'])->name('vehiculos.listar');

        Route::get('/espacios/mapa', [EspacioController::class, 'mapa'])->name('espacios.mapa');
        Route::get('/espacios/listar', [EspacioController::class, 'listar'])->name('espacios.listar');

        Route::get('/mensualidades', [MensualidadController::class, 'index'])->name('mensualidades.index');
        Route::get('/mensualidades/listar', [MensualidadController::class, 'listar'])->name('mensualidades.listar');
    });

    Route::middleware('rol:Administrador,Operador/Cajero')->group(function () {
        Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
        Route::put('/clientes/{id}', [ClienteController::class, 'update'])->name('clientes.update');
        Route::put('/clientes/{id}/estado', [ClienteController::class, 'cambiarEstado'])->name('clientes.estado');

        Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');
        Route::put('/vehiculos/{id}', [VehiculoController::class, 'update'])->name('vehiculos.update');
        Route::put('/vehiculos/{id}/estado', [VehiculoController::class, 'cambiarEstado'])->name('vehiculos.estado');

        Route::get('/entradas', [EntradaController::class, 'index'])->name('entradas.index');
        Route::get('/entradas/listar', [EntradaController::class, 'listar'])->name('entradas.listar');
        Route::get('/entradas/buscar', [EntradaController::class, 'buscar'])->name('entradas.buscar');
        Route::post('/entradas', [EntradaController::class, 'store'])->name('entradas.store');
        Route::get('/entradas/{id}/ticket', [EntradaController::class, 'ticket'])->name('entradas.ticket');

        Route::get('/salidas', [SalidaController::class, 'index'])->name('salidas.index');
        Route::get('/salidas/buscar', [SalidaController::class, 'buscar'])->name('salidas.buscar');
        Route::put('/salidas/{id}/cobrar', [SalidaController::class, 'cobrar'])->name('salidas.cobrar');
        Route::get('/salidas/{id}/comprobante', [SalidaController::class, 'comprobante'])->name('salidas.comprobante');

        Route::post('/mensualidades', [MensualidadController::class, 'store'])->name('mensualidades.store');
    });

    Route::middleware('rol:Administrador,Supervisor')->group(function () {
        Route::get('/caja', [CajaController::class, 'index'])->name('caja.index');
        Route::get('/caja/listar', [CajaController::class, 'listar'])->name('caja.listar');

        Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('/reportes/ingresos', [ReporteController::class, 'ingresos'])->name('reportes.ingresos');
        Route::get('/reportes/frecuentes', [ReporteController::class, 'frecuentes'])->name('reportes.frecuentes');
        Route::get('/reportes/ocupacion', [ReporteController::class, 'ocupacion'])->name('reportes.ocupacion');
        Route::get('/reportes/ocupacion-actual', [ReporteController::class, 'ocupacionActual'])->name('reportes.ocupacion_actual');
    });

    Route::middleware('rol:Administrador')->group(function () {
        Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/usuarios/listar', [UsuarioController::class, 'listar'])->name('usuarios.listar');
        Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::put('/usuarios/{id}/estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.estado');

        Route::get('/tipos-vehiculo', [TipoVehiculoController::class, 'index'])->name('tipos.index');
        Route::get('/tipos-vehiculo/listar', [TipoVehiculoController::class, 'listar'])->name('tipos.listar');
        Route::post('/tipos-vehiculo', [TipoVehiculoController::class, 'store'])->name('tipos.store');
        Route::put('/tipos-vehiculo/{id}', [TipoVehiculoController::class, 'update'])->name('tipos.update');

        Route::get('/tarifas', [TarifaController::class, 'index'])->name('tarifas.index');
        Route::get('/tarifas/listar', [TarifaController::class, 'listar'])->name('tarifas.listar');
        Route::post('/tarifas', [TarifaController::class, 'store'])->name('tarifas.store');
        Route::put('/tarifas/{id}', [TarifaController::class, 'update'])->name('tarifas.update');
        Route::put('/tarifas/{id}/estado', [TarifaController::class, 'cambiarEstado'])->name('tarifas.estado');

        Route::get('/espacios', [EspacioController::class, 'index'])->name('espacios.index');
        Route::post('/espacios', [EspacioController::class, 'store'])->name('espacios.store');
        Route::put('/espacios/{id}', [EspacioController::class, 'update'])->name('espacios.update');
        Route::put('/espacios/{id}/estado', [EspacioController::class, 'cambiarEstado'])->name('espacios.estado');
    });
});
