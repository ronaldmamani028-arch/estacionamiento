<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa', 15)->unique();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes');
            $table->foreignId('tipo_vehiculo_id')->constrained('tipos_vehiculo');
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->string('color', 30);
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculos');
    }
};
