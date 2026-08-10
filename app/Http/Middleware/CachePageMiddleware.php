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
            try {
                $cachedContent = Cache::get($key);
                
                // ─── LOG CACHE HIT ───
                if (env('CACHE_DEBUG', false)) {
                    Log::info('Page cache hit', [
                        'url' => $request->fullUrl(),
                        'key' => $key,
                    ]);
                }

                // ─── RETURN CACHED CONTENT AS RESPONSE ───
                return response($cachedContent);
            } catch (\Exception $e) {
                // ─── IF CACHE IS CORRUPTED, CLEAR IT ───
                Log::warning('Page cache corrupted, clearing', [
                    'key' => $key,
                    'error' => $e->getMessage(),
                ]);
                Cache::forget($key);
                // ─── CONTINUE TO GENERATE NEW CACHE ───
            }
        }

        // ─── GET RESPONSE ───
        $response = $next($request);

        // ─── ONLY CACHE SUCCESSFUL RESPONSES ───
        if ($response->getStatusCode() === 200) {
            $ttl = (int) env('PAGE_CACHE_TTL', 3600);
            
            try {
                // ─── STORE ONLY THE CONTENT, NOT THE FULL RESPONSE OBJECT ───
                Cache::put($key, $response->getContent(), $ttl);

                // ─── LOG CACHE STORE ───
                if (env('CACHE_DEBUG', false)) {
                    Log::info('Page cache stored', [
                        'url' => $request->fullUrl(),
                        'key' => $key,
                        'ttl' => $ttl,
                        'content_length' => strlen($response->getContent()),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Page cache storage failed', [
                    'key' => $key,
                    'error' => $e->getMessage(),
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
        if (session()->has('payment_order_number') || session()->has('payment_status')) {
            return false;
        }

        // ─── CHECK FOR PENDING REGISTRATION ───
        if (session()->has('pending_registration_')) {
            return false;
        }

        // ─── CHECK FOR ANY PENDING REGISTRATION IN SESSION ───
        $sessionKeys = session()->all();
        foreach (array_keys($sessionKeys) as $key) {
            if (str_starts_with($key, 'pending_registration_')) {
                return false;
            }
        }

        // ─── CHECK FOR FLASH MESSAGES ───
        if (session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info')) {
            return false;
        }

        // ─── CHECK FOR USER-SPECIFIC DATA ───
        $excludedSessionKeys = [
            '_token',
            '_previous',
            '_flash',
            '_old_input',
            'login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d', // Laravel's session auth key
        ];
        
        foreach (array_keys($sessionKeys) as $key) {
            if (str_starts_with($key, 'pending_registration_')) {
                return false;
            }
            if (str_starts_with($key, 'payment_')) {
                return false;
            }
            if (str_starts_with($key, 'cart_')) {
                return false;
            }
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
        
        // ─── ADD FLASH MESSAGE STATE TO KEY ───
        $flashKeys = ['success', 'error', 'warning', 'info'];
        $flashState = '';
        foreach ($flashKeys as $key) {
            if (session()->has($key)) {
                $flashState .= $key . '=' . md5(session()->get($key) ?? '') . '_';
            }
        }
        
        $key = 'page_' . md5($method . '_' . $url . '_' . $query . '_' . $flashState);
        
        return $key;
    }
}