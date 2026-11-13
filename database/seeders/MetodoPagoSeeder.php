<?php

namespace Database\Seeders;

use App\Models\MetodoPago;
use Illuminate\Database\Seeder;

class MetodoPagoSeeder extends Seeder
{
    public function run(): void
    {
        MetodoPago::create(['nombre' => 'Efectivo']);
        MetodoPago::create(['nombre' => 'QR Yape']);
    }
}
