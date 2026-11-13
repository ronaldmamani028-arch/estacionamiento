<?php

namespace Database\Seeders;

use App\Models\TipoVehiculo;
use Illuminate\Database\Seeder;

class TipoVehiculoSeeder extends Seeder
{
    public function run(): void
    {
        TipoVehiculo::create(['nombre' => 'Auto']);
        TipoVehiculo::create(['nombre' => 'Moto']);
        TipoVehiculo::create(['nombre' => 'Camioneta']);
    }
}
