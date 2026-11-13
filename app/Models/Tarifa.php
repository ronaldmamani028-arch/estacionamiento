<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarifa extends Model
{
    protected $table = 'tarifas';

    protected $fillable = [
        'tipo_vehiculo_id',
        'precio_hora',
        'minutos_fraccion',
        'precio_mensualidad',
        'estado',
    ];

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipo_vehiculo_id');
    }
}
