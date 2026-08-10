<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class RateLimitServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // ─── GLOBAL RATE LIMIT ───
        RateLimiter::for('global', function (Request $request) {
            $maxAttempts = config('app.rate_limits.global', 60);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many requests. Please slow down.',
                    ], 429);
                });
        });

        // ─── LOGIN RATE LIMIT ───
        RateLimiter::for('login', function (Request $request) {
            $maxAttempts = config('app.rate_limits.login', 5);
            return Limit::perMinute($maxAttempts)
                ->by($request->input('email', '') . '|' . $request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many login attempts. Please wait before trying again.',
                    ], 429);
                });
        });

        // ─── CONTACT FORM RATE LIMIT (POST) ───
        RateLimiter::for('contact', function (Request $request) {
            $maxAttempts = config('app.rate_limits.contact', 3);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many contact form submissions. Please wait before sending another message.',
                    ], 429);
                });
        });

        // ─── CONTACT GET RATE LIMIT ───
        RateLimiter::for('contact_get', function (Request $request) {
            return Limit::perMinute(30)
                ->by($request->ip())
                ->response(function () {
                    return response()->view('errors.429', [
                        'message' => 'Too many requests. Please wait a moment before refreshing.',
                    ], 429);
                });
        });

        // ─── BAPTISM REQUEST RATE LIMIT ───
        RateLimiter::for('baptism', function (Request $request) {
            $maxAttempts = config('app.rate_limits.baptism', 3);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many baptism requests. Please wait before submitting another request.',
                    ], 429);
                });
        });

        // ─── INVITE REQUEST RATE LIMIT ───
        RateLimiter::for('invite', function (Request $request) {
            $maxAttempts = config('app.rate_limits.invite', 3);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many invite requests. Please wait before sending another invitation.',
                    ], 429);
                });
        });

        // ─── PAYMENT RATE LIMIT ───
        RateLimiter::for('payment', function (Request $request) {
            $maxAttempts = config('app.rate_limits.payment', 10);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Too many payment attempts. Please wait before trying again.',
                    ], 429);
                });
        });

        // ─── API RATE LIMIT ───
        RateLimiter::for('api', function (Request $request) {
            $maxAttempts = config('app.rate_limits.api', 60);
            return Limit::perMinute($maxAttempts)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'API rate limit exceeded. Please wait before making another request.',
                    ], 429);
                });
        });
    }
}