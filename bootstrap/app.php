<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__.'/../routes/web.php', 
            __DIR__.'/../routes/admin.php'
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin.auth' => \App\Http\Middleware\AdminMiddleware::class,
            'bot.block' => \App\Http\Middleware\BotBlockerMiddleware::class,
            'security.headers' => \App\Http\Middleware\SecurityHeadersMiddleware::class,
            'cache.page' => \App\Http\Middleware\CachePageMiddleware::class,
        ]);

        // ─── GLOBAL MIDDLEWARE ───
        $middleware->append([
            \App\Http\Middleware\SecurityHeadersMiddleware::class,
            \App\Http\Middleware\BotBlockerMiddleware::class,
            \App\Http\Middleware\CachePageMiddleware::class,
        ]);

        // ─── CSRF EXCEPTION - PAYMENT ROUTES ───
        $middleware->validateCsrfTokens(except: [
            'payment/webhook/*',
            'payment/return/*',
            'payment/cancel/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();