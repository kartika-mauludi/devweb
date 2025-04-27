<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(HandleCors::class);
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'user' => \App\Http\Middleware\User::class,
        ]);
        $middleware->web(append: [
            \App\Http\Middleware\EnsureSessionIsValid::class,
        ], 
        replace: [
            Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class =>
            App\Http\Middleware\CheckCsrf::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
