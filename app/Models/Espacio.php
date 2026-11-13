<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espacio extends Model
{
    protected $table = 'espacios';

    protected $fillable = [
        'piso',
        'sector',
        'numero',
        'esta_ocupado',
        'estado',
    ];

    public function boletoAbierto()
    {
        return $this->hasOne(Boleto::class, 'espacio_id')->whereNull('hora_salida');
    }
}
