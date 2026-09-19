<?php

use App\Http\Middleware\PastikanPeran;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware peran — untuk halaman Filament kustom:
        //   ->middleware('peran:admin')
        //   ->middleware('peran:admin,direktur')
        $middleware->alias([
            'peran' => PastikanPeran::class,
        ]);

        // Tamu yang membuka rute ber-middleware `auth` diarahkan LANGSUNG
        // ke halaman login Filament — bukan lewat /login dulu (2 hop).
        // Ini berlaku untuk rute biasa seperti /admin/laporan/ekspor/{jenis}.
        $middleware->redirectGuestsTo(fn () => '/admin/login');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
