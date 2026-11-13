<?php

namespace Database\Seeders;

use App\Models\Espacio;
use Illuminate\Database\Seeder;

class EspacioSeeder extends Seeder
{
    public function run(): void
    {
        $sectores = [
            [1, 'A'],
            [1, 'B'],
            [2, 'A'],
        ];

        foreach ($sectores as $s) {
            for ($numero = 1; $numero <= 10; $numero++) {
                Espacio::create([
                    'piso' => $s[0],
                    'sector' => $s[1],
                    'numero' => $numero,
                    'esta_ocupado' => 0,
                    'estado' => 1,
                ]);
            }
        }
    }
}
