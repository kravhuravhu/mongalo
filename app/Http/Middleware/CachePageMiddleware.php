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
        'baptism',
        'invite',
        'events/*',
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

        // ─── EXCLUDE ROUTES WITH FLASH MESSAGES ───
        // Check if any flash messages exist in session
        if ($this->hasFlashMessages()) {
            // ─── CLEAR CACHE FOR THIS URL ───
            $cacheKey = $this->generateCacheKey($request);
            if (Cache::has($cacheKey)) {
                Cache::forget($cacheKey);
                if (env('CACHE_DEBUG', false)) {
                    Log::info('Cache cleared - flash message present', [
                        'url' => $request->fullUrl(),
                        'key' => $cacheKey,
                    ]);
                }
            }
            // ─── PROCESS REQUEST WITHOUT CACHING ───
            return $next($request);
        }

        // ─── EXCLUDE SPECIFIC ROUTES ───
        foreach ($this->excludedRoutes as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        // ─── CHECK IF REQUEST SHOULD BE CACHED ───
        if (!$this->shouldCache($request)) {
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

                // ─── RETURN CACHED CONTENT ───
                return response($cachedContent);
            } catch (\Exception $e) {
                Log::warning('Page cache corrupted, clearing', [
                    'key' => $key,
                    'error' => $e->getMessage(),
                ]);
                Cache::forget($key);
            }
        }

        // ─── GET RESPONSE ───
        $response = $next($request);

        // ─── ONLY CACHE SUCCESSFUL RESPONSES ───
        if ($response->getStatusCode() === 200) {
            // ─── DON'T CACHE IF FLASH MESSAGES WERE ADDED ───
            if ($this->hasFlashMessages()) {
                return $response;
            }

            // ─── DON'T CACHE IF USER IS AUTHENTICATED ───
            if (auth()->check()) {
                return $response;
            }

            // ─── DON'T CACHE IF PAYMENT SESSION DATA EXISTS ───
            if (session()->has('payment_order_number') || session()->has('payment_status')) {
                return $response;
            }

            // ─── DON'T CACHE IF PENDING REGISTRATION EXISTS ───
            if ($this->hasPendingRegistration()) {
                return $response;
            }

            $ttl = (int) env('PAGE_CACHE_TTL', 3600);
            
            try {
                Cache::put($key, $response->getContent(), $ttl);

                if (env('CACHE_DEBUG', false)) {
                    Log::info('Page cache stored', [
                        'url' => $request->fullUrl(),
                        'key' => $key,
                        'ttl' => $ttl,
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
     * Check if flash messages exist in session
     */
    protected function hasFlashMessages(): bool
    {
        $flashKeys = ['success', 'error', 'warning', 'info'];
        foreach ($flashKeys as $key) {
            if (session()->has($key)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if pending registration exists in session
     */
    protected function hasPendingRegistration(): bool
    {
        if (session()->has('pending_registration_')) {
            return true;
        }

        $sessionKeys = session()->all();
        foreach (array_keys($sessionKeys) as $key) {
            if (str_starts_with($key, 'pending_registration_')) {
                return true;
            }
        }

        return false;
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
        if ($this->hasPendingRegistration()) {
            return false;
        }

        // ─── CHECK FOR USER-SPECIFIC DATA ───
        $sessionKeys = session()->all();
        $excludedSessionKeys = [
            '_token',
            '_previous',
            '_flash',
            '_old_input',
            'login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d',
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
        
        return 'page_' . md5($method . '_' . $url . '_' . $query);
    }
}