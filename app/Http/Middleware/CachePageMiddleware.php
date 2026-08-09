<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CachePageMiddleware
{
    protected array $excludedRoutes = [
        'admin/*',
        'payment/*',
        'checkout/*',
        'login',
        'logout',
        'register',
        'contact',
        'baptism/request',
        'invite/send',
        'events/register',
    ];

    protected array $excludedMethods = [
        'POST',
        'PUT',
        'PATCH',
        'DELETE',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // ─── CHECK IF PAGE CACHE ENABLED ───
        if (!env('PAGE_CACHE_ENABLED', true)) {
            return $next($request);
        }

        // ─── EXCLUDE POST, PUT, DELETE REQUESTS ───
        if (in_array($request->method(), $this->excludedMethods)) {
            return $next($request);
        }

        // ─── EXCLUDE ADMIN ROUTES ───
        if ($request->is('admin/*') || $request->is('admin')) {
            return $next($request);
        }

        // ─── EXCLUDE PAYMENT ROUTES ───
        if ($request->is('payment/*')) {
            return $next($request);
        }

        // ─── EXCLUDE CHECKOUT ROUTES ───
        if ($request->is('checkout/*')) {
            return $next($request);
        }

        // ─── EXCLUDE AUTH ROUTES ───
        if ($request->is('login') || $request->is('logout') || $request->is('register')) {
            return $next($request);
        }

        // ─── EXCLUDE FORM SUBMISSION ROUTES ───
        if ($request->is('contact') && $request->method() === 'POST') {
            return $next($request);
        }
        if ($request->is('baptism/request')) {
            return $next($request);
        }
        if ($request->is('invite/send')) {
            return $next($request);
        }
        if ($request->is('events/register')) {
            return $next($request);
        }

        // ─── CHECK IF REQUEST SHOULD BE CACHED ───
        $shouldCache = $this->shouldCache($request);
        if (!$shouldCache) {
            return $next($request);
        }

        // ─── GENERATE CACHE KEY ───
        $key = $this->generateCacheKey($request);

        // ─── CHECK CACHE ───
        if (Cache::has($key)) {
            $cachedResponse = Cache::get($key);
            
            // ─── LOG CACHE HIT ───
            if (env('CACHE_DEBUG', false)) {
                Log::info('Page cache hit', [
                    'url' => $request->fullUrl(),
                    'key' => $key,
                ]);
            }

            return $cachedResponse;
        }

        // ─── GET RESPONSE ───
        $response = $next($request);

        // ─── ONLY CACHE SUCCESSFUL RESPONSES ───
        if ($response->getStatusCode() === 200) {
            $ttl = (int) env('PAGE_CACHE_TTL', 3600);
            
            Cache::put($key, $response, $ttl);

            // ─── LOG CACHE STORE ───
            if (env('CACHE_DEBUG', false)) {
                Log::info('Page cache stored', [
                    'url' => $request->fullUrl(),
                    'key' => $key,
                    'ttl' => $ttl,
                ]);
            }
        }

        return $response;
    }

    /**
     * Check if request should be cached
     */
    protected function shouldCache(Request $request): bool
    {
        // ─── CHECK FOR CACHE-BUSTING PARAMETERS ───
        if ($request->has('nocache') || $request->has('_nocache')) {
            return false;
        }

        // ─── CHECK FOR AUTHENTICATED USERS ───
        if (auth()->check()) {
            return false;
        }

        // ─── CHECK FOR SESSION DATA ───
        if (session()->has('payment_order_number') || session()->has('pending_registration')) {
            return false;
        }

        // ─── CHECK FOR FLASH MESSAGES ───
        if (session()->has('success') || session()->has('error') || session()->has('warning')) {
            return false;
        }

        return true;
    }

    /**
     * Generate cache key for request
     */
    protected function generateCacheKey(Request $request): string
    {
        $url = $request->fullUrl();
        $method = $request->method();
        $query = http_build_query($request->query());
        
        // ─── REMOVE CACHE-BUSTING PARAMETERS ───
        $query = preg_replace('/&?nocache=[^&]*/', '', $query);
        $query = preg_replace('/&?_nocache=[^&]*/', '', $query);
        
        $key = 'page_' . md5($method . '_' . $url . '_' . $query);
        
        return $key;
    }
}