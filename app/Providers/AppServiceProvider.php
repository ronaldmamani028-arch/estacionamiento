<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Gate::define('administrar', function ($user) {
            return $user->rol->nombre == 'Administrador';
        });

        Gate::define('operar', function ($user) {
            return in_array($user->rol->nombre, ['Administrador', 'Operador/Cajero']);
        });

        Gate::define('supervisar', function ($user) {
            return in_array($user->rol->nombre, ['Administrador', 'Supervisor']);
        });
    }
}
