<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CacheService
{
    protected int $defaultTtl;
    protected bool $isEnabled;

    public function __construct()
    {
        $this->defaultTtl = (int) env('CACHE_TTL', 3600);
        $this->isEnabled = env('CACHE_ENABLED', true);
    }

    /**
     * Get cached data or store if not exists
     */
    public function remember(string $key, array $data, ?int $ttl = null): mixed
    {
        if (!$this->isEnabled) {
            return $data;
        }

        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::remember($key, $ttl, function () use ($data) {
            return $data;
        });
    }

    /**
     * Get cached data or store closure result
     */
    public function rememberClosure(string $key, \Closure $callback, ?int $ttl = null): mixed
    {
        if (!$this->isEnabled) {
            return $callback();
        }

        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::remember($key, $ttl, $callback);
    }

    /**
     * Get cached data
     */
    public function get(string $key): mixed
    {
        if (!$this->isEnabled) {
            return null;
        }

        return Cache::get($key);
    }

    /**
     * Store data in cache
     */
    public function put(string $key, mixed $value, ?int $ttl = null): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        $ttl = $ttl ?? $this->defaultTtl;

        return Cache::put($key, $value, $ttl);
    }

    /**
     * Check if cache has key
     */
    public function has(string $key): bool
    {
        if (!$this->isEnabled) {
            return false;
        }

        return Cache::has($key);
    }

    /**
     * Forget cached data
     */
    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Clear all cache
     */
    public function flush(): bool
    {
        return Cache::flush();
    }

    /**
     * Generate cache key
     */
    public function key(string $prefix, array $data): string
    {
        $hash = md5(json_encode($data));
        return $prefix . '_' . $hash;
    }

    /**
     * Log cache hit/miss
     */
    public function log(string $action, string $key, mixed $data = null): void
    {
        if (env('CACHE_DEBUG', false)) {
            Log::info('Cache: ' . $action, [
                'key' => $key,
                'data' => $data ? 'present' : 'null',
            ]);
        }
    }
}