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
        // Alias middleware peran — berguna untuk halaman Filament kustom:
        //   ->middleware('peran:admin')
        //   ->middleware('peran:admin,direktur')
        //
        // Untuk CRUD standar, pembatasan sudah dilakukan di masing-masing
        // Resource lewat canCreate/canEdit/canDelete + trait BolehUbahData.
        $middleware->alias([
            'peran' => PastikanPeran::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
