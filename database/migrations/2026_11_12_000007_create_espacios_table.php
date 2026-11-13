<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('espacios', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('piso');
            $table->string('sector', 5);
            $table->unsignedSmallInteger('numero');
            $table->boolean('esta_ocupado')->default(0);
            $table->boolean('estado')->default(1);
            $table->timestamps();

            $table->unique(['piso', 'sector', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('espacios');
    }
};
