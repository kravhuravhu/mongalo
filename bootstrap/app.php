<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
            'rate.limit' => \App\Http\Middleware\RateLimitMiddleware::class,
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
        // ─── JSON RESPONSES FOR API REQUESTS ───
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson() || $request->ajax()
        );

        // ─── CUSTOM 404 RESPONSE ───
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found.',
                    'error' => 'Not Found',
                    'code' => 404,
                ], 404);
            }
        });

        // ─── CUSTOM 403 RESPONSE ───
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 403) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Access denied. You do not have permission.',
                        'error' => 'Forbidden',
                        'code' => 403,
                    ], 403);
                }
            }

            // ─── CUSTOM 401 RESPONSE ───
            if ($e->getStatusCode() === 401) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Unauthorized. Please log in.',
                        'error' => 'Unauthorized',
                        'code' => 401,
                    ], 401);
                }
            }

            // ─── CUSTOM 429 RESPONSE ───
            if ($e->getStatusCode() === 429) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many requests. Please slow down.',
                        'error' => 'Too Many Requests',
                        'code' => 429,
                        'retry_after' => $e->getHeaders()['Retry-After'] ?? 60,
                    ], 429);
                }
            }

            // ─── CUSTOM 419 RESPONSE ───
            if ($e->getStatusCode() === 419) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Session expired. Please refresh the page.',
                        'error' => 'Session Expired',
                        'code' => 419,
                    ], 419);
                }
            }

            // ─── CUSTOM 500 RESPONSE ───
            if ($e->getStatusCode() === 500) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'An internal server error occurred. Please try again later.',
                        'error' => 'Internal Server Error',
                        'code' => 500,
                    ], 500);
                }
            }

            // ─── CUSTOM 503 RESPONSE ───
            if ($e->getStatusCode() === 503) {
                if ($request->is('api/*') || $request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Service unavailable. Please try again later.',
                        'error' => 'Service Unavailable',
                        'code' => 503,
                    ], 503);
                }
            }
        });
    })->create();