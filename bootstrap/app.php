<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware; // Pastikan ini di-import

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { // <-- Metode yang hilang
        // Tambahkan middleware alias Anda di sini:
        $middleware->alias([
            // ... middleware alias default Laravel lainnya
            'admin' => \App\Http\Middleware\IsAdmin::class, // <-- Middleware alias Anda
        ]);

        // Anda juga bisa mendaftarkan middleware group atau global di sini
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();