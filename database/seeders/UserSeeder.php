<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rolAdmin = Rol::where('nombre', 'Administrador')->first();

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@estacionamiento.com',
            'password' => 'admin123',
            'rol_id' => $rolAdmin->id,
            'estado' => 1,
        ]);
    }
}
