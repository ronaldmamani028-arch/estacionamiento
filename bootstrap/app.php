<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'rol' => \App\Http\Middleware\CheckRol::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() == 419) {
                session()->flash('error', 'Tu sesión expiró, vuelve a intentarlo.');

                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Tu sesión expiró, vuelve a intentarlo.'], 419);
                }

                return redirect()->route('login');
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->ajax()) {
                session()->flash('error', 'Tu sesión expiró, vuelve a intentarlo.');
                return response()->json(['success' => false, 'message' => 'Tu sesión expiró, vuelve a intentarlo.'], 401);
            }
        });
    })->create();
