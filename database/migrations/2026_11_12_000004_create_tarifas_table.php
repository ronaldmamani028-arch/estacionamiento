<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_vehiculo_id')->unique()->constrained('tipos_vehiculo');
            $table->decimal('precio_hora', 10, 2);
            $table->unsignedSmallInteger('minutos_fraccion');
            $table->decimal('precio_mensualidad', 10, 2);
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
