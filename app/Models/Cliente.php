<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'ci',
        'telefono',
        'correo_electronico',
        'es_abonado',
        'estado',
    ];
}
