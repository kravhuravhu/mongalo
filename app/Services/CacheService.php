<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Collection;

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
     * This is the safe version - it serializes properly
     */
    public function rememberClosure(string $key, \Closure $callback, ?int $ttl = null): mixed
    {
        if (!$this->isEnabled) {
            return $callback();
        }

        $ttl = $ttl ?? $this->defaultTtl;

        // ─── CHECK IF CACHE EXISTS ───
        if (Cache::has($key)) {
            $cached = Cache::get($key);
            
            // ─── IF CACHED DATA IS VALID, RETURN IT ───
            if ($cached !== null) {
                return $cached;
            }
        }

        // ─── EXECUTE CALLBACK AND CACHE RESULT ───
        $result = $callback();
        
        // ─── ONLY CACHE IF RESULT IS SERIALIZABLE ───
        if ($this->isSerializable($result)) {
            Cache::put($key, $result, $ttl);
        } else {
            Log::warning('Cache: Result not serializable', [
                'key' => $key,
                'type' => gettype($result),
            ]);
        }

        return $result;
    }

    /**
     * Check if value is serializable for cache
     */
    protected function isSerializable($value): bool
    {
        // ─── NULL IS ALWAYS SERIALIZABLE ───
        if ($value === null) {
            return true;
        }

        // ─── SCALAR TYPES ARE ALWAYS SERIALIZABLE ───
        if (is_scalar($value)) {
            return true;
        }

        // ─── ARRAYS ARE SERIALIZABLE IF ALL VALUES ARE ───
        if (is_array($value)) {
            foreach ($value as $item) {
                if (!$this->isSerializable($item)) {
                    return false;
                }
            }
            return true;
        }

        // ─── ELOQUENT COLLECTIONS AND MODELS ARE SERIALIZABLE ───
        if ($value instanceof \Illuminate\Database\Eloquent\Collection) {
            return true;
        }

        if ($value instanceof \Illuminate\Database\Eloquent\Model) {
            return true;
        }

        // ─── STANDARD COLLECTIONS ARE SERIALIZABLE ───
        if ($value instanceof \Illuminate\Support\Collection) {
            return true;
        }

        // ─── CUSTOM OBJECTS MIGHT NOT BE SERIALIZABLE ───
        if (is_object($value)) {
            // ─── CHECK IF IT HAS A __SERIALIZE METHOD ───
            if (method_exists($value, '__serialize') || method_exists($value, 'serialize')) {
                return true;
            }
            
            Log::warning('Cache: Object may not be serializable', [
                'class' => get_class($value),
            ]);
            return false;
        }

        return true;
    }

    /**
     * Get cached data
     */
    public function get(string $key): mixed
    {
        if (!$this->isEnabled) {
            return null;
        }

        if (Cache::has($key)) {
            try {
                return Cache::get($key);
            } catch (\Exception $e) {
                Log::error('Cache: Failed to retrieve', [
                    'key' => $key,
                    'error' => $e->getMessage(),
                ]);
                Cache::forget($key);
                return null;
            }
        }

        return null;
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

        try {
            return Cache::put($key, $value, $ttl);
        } catch (\Exception $e) {
            Log::error('Cache: Failed to store', [
                'key' => $key,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
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