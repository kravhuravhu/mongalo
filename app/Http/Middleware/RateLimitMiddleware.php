<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;

class RateLimitMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $type = 'global')
    {
        // ─── CHECK IF RATE LIMITING ENABLED ───
        if (!config('app.rate_limits.enabled', true)) {
            return $next($request);
        }

        // ─── GET LIMITS ───
        $limits = config('app.rate_limits', []);
        $maxAttempts = $limits[$type] ?? $limits['global'] ?? 60;
        $decayMinutes = 1;

        // ─── GENERATE UNIQUE KEY ───
        $key = $this->generateKey($request, $type);

        // ─── CHECK RATE LIMIT ───
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = RateLimiter::availableIn($key);

            // ─── LOG RATE LIMIT HIT ───
            Log::warning('Rate limit exceeded', [
                'type' => $type,
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'user_agent' => $request->userAgent(),
                'retry_after' => $retryAfter,
            ]);

            // ─── CHECK IF REQUEST EXPECTS JSON ───
            if ($request->expectsJson() || $request->ajax() || $request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests. Please wait ' . ceil($retryAfter / 60) . ' minute(s).',
                    'retry_after' => $retryAfter,
                ], 429)->withHeaders([
                    'Retry-After' => $retryAfter,
                    'X-RateLimit-Limit' => $maxAttempts,
                    'X-RateLimit-Remaining' => 0,
                    'X-RateLimit-Reset' => time() + $retryAfter,
                ]);
            }

            // ─── FOR HTML REQUESTS, RETURN 429 ERROR PAGE ───
            return response()->view('errors.429', [
                'retry_after' => ceil($retryAfter / 60),
                'retry_seconds' => $retryAfter,
                'message' => 'Too many requests. Please wait ' . ceil($retryAfter / 60) . ' minute(s).',
            ], 429)->withHeaders([
                'Retry-After' => $retryAfter,
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
                'X-RateLimit-Reset' => time() + $retryAfter,
            ]);
        }

        // ─── HIT THE RATE LIMITER ───
        RateLimiter::hit($key, $decayMinutes * 60);

        // ─── GET REMAINING ATTEMPTS ───
        $remaining = RateLimiter::remaining($key, $maxAttempts);

        // ─── ADD HEADERS TO RESPONSE ───
        $response = $next($request);
        
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $remaining);

        return $response;
    }

    /**
     * Generate unique key for rate limiting
     */
    protected function generateKey(Request $request, string $type): string
    {
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        
        // ─── FOR LOGIN, USE EMAIL + IP ───
        if ($type === 'login') {
            $email = $request->input('email', 'unknown');
            return 'rate_limit_' . $type . '_' . md5($email . '_' . $ip);
        }

        // ─── FOR AUTHENTICATED USERS, USE USER ID ───
        if (auth()->check()) {
            return 'rate_limit_' . $type . '_' . auth()->id();
        }

        // ─── FOR GUESTS, USE IP + USER AGENT ───
        return 'rate_limit_' . $type . '_' . md5($ip . '_' . $userAgent);
    }
}