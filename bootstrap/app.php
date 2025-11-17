<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Http\Request; // <-- TAMBAHKAN IMPORT INI

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias route middleware
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);

        
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika rute yang diakses adalah rute admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // return ke login page
            return route('employee.login');
        });
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();