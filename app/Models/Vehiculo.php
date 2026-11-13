<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';

    protected $fillable = [
        'placa',
        'cliente_id',
        'tipo_vehiculo_id',
        'marca',
        'modelo',
        'color',
        'estado',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tipoVehiculo()
    {
        return $this->belongsTo(TipoVehiculo::class, 'tipo_vehiculo_id');
    }

    public function boletoAbierto()
    {
        return $this->hasOne(Boleto::class, 'vehiculo_id')->whereNull('hora_salida');
    }
}
