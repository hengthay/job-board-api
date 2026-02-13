<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: [
            'token',
        ]);

        // Register the JWT middleware alias, and all route must be authenticate with this alias name, in order to check-auth
        $middleware->alias([
            'jwt.cookie' => App\Http\Middleware\JwtCookieAuth::class,
            'admin' => App\Http\Middleware\AdminMiddleware::class,
            'employer' => App\Http\Middleware\CompanyMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
