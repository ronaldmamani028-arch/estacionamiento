<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boletos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20)->nullable()->unique();
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->foreignId('espacio_id')->constrained('espacios');
            $table->foreignId('user_id')->constrained('users');
            $table->dateTime('hora_entrada');
            $table->dateTime('hora_salida')->nullable();
            $table->unsignedInteger('total_minutos')->nullable();
            $table->decimal('monto_total', 10, 2)->nullable();
            $table->foreignId('metodo_pago_id')->nullable()->constrained('metodos_pago');
            $table->string('numero_operacion', 50)->nullable();
            $table->boolean('es_abonado')->default(0);
            $table->boolean('esta_pagado')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boletos');
    }
};
