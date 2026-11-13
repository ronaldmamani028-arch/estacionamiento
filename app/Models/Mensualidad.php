<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    protected $table = 'mensualidades';

    protected $fillable = [
        'cliente_id',
        'user_id',
        'monto',
        'fecha_inicio',
        'fecha_fin',
        'metodo_pago_id',
        'numero_operacion',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y H:i');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
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
