<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    protected $table = 'boletos';

    protected $fillable = [
        'codigo',
        'vehiculo_id',
        'espacio_id',
        'user_id',
        'hora_entrada',
        'hora_salida',
        'total_minutos',
        'monto_total',
        'metodo_pago_id',
        'numero_operacion',
        'es_abonado',
        'esta_pagado',
    ];

    protected function casts(): array
    {
        return [
            'hora_entrada' => 'datetime:d/m/Y H:i',
            'hora_salida' => 'datetime:d/m/Y H:i',
        ];
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id');
    }

    public function espacio()
    {
        return $this->belongsTo(Espacio::class, 'espacio_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }
}
