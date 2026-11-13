<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensualidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('user_id')->constrained('users');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->string('numero_operacion', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensualidades');
    }
};
