<?php

namespace Database\Seeders;

use App\Models\Tarifa;
use App\Models\TipoVehiculo;
use Illuminate\Database\Seeder;

class TarifaSeeder extends Seeder
{
    public function run(): void
    {
        $tarifas = [
            ['Auto',       5,       30,               300],
            ['Moto',       3,       30,               150],
            ['Camioneta',  7,       30,               400],
        ];

        foreach ($tarifas as $t) {
            $tipo = TipoVehiculo::where('nombre', $t[0])->first();

            Tarifa::create([
                'tipo_vehiculo_id' => $tipo->id,
                'precio_hora' => $t[1],
                'minutos_fraccion' => $t[2],
                'precio_mensualidad' => $t[3],
                'estado' => 1,
            ]);
        }
    }
}
