<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

trait QueryCacheable
{
    /**
     * Get cached query result
     */
    public function cachedQuery(string $key, \Closure $query, ?int $ttl = null): mixed
    {
        if (!env('QUERY_CACHE_ENABLED', true)) {
            return $query();
        }

        $ttl = $ttl ?? (int) env('QUERY_CACHE_TTL', 3600);

        if (Cache::has($key)) {
            try {
                $cached = Cache::get($key);

                // ─── REJECT POISONED / INCOMPLETE OBJECTS ───
                if ($cached instanceof \__PHP_Incomplete_Class) {
                    Cache::forget($key);
                    Log::warning('QueryCacheable: poisoned cache entry cleared', [
                        'key' => $key,
                    ]);
                } elseif ($cached !== null) {
                    return $cached;
                }
            } catch (\Throwable $e) {
                Cache::forget($key);
                Log::warning('QueryCacheable: failed to read cache, cleared', [
                    'key'   => $key,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $result = $query();

        // ─── ONLY CACHE SCALARS AND ARRAYS OF SCALARS ───
        // Eloquent models/collections are never cached here — they are
        // cached as plain ID arrays by the model methods instead.
        if ($this->isCacheSafe($result)) {
            Cache::put($key, $result, $ttl);
        } else {
            Log::warning('QueryCacheable: result not cache-safe, skipped', [
                'key'  => $key,
                'type' => get_debug_type($result),
            ]);
        }

        return $result;
    }

    /**
     * Only scalars, null, and arrays of scalars are considered cache-safe.
     */
    protected function isCacheSafe(mixed $value): bool
    {
        if ($value === null || is_scalar($value)) {
            return true;
        }

        if (is_array($value)) {
            foreach ($value as $item) {
                if (!$this->isCacheSafe($item)) {
                    return false;
                }
            }
            return true;
        }

        return false;
    }

    /**
     * Forget cached query
     */
    public function forgetCachedQuery(string $key): bool
    {
        return Cache::forget($key);
    }

    /**
     * Generate query cache key
     */
    public function queryKey(string $model, array $params = []): string
    {
        $hash = md5(json_encode($params));
        return 'query_' . $model . '_' . $hash;
    }

    /**
     * Clear all query cache for a model
     */
    public function clearModelCache(string $model): void
    {
        // ─── VERSIONED KEY ───
        $versionKey = 'query_version_' . $model;
        $currentVersion = Cache::get($versionKey, 1);
        Cache::put($versionKey, $currentVersion + 1, 86400);
    }

    /**
     * Get versioned query key
     */
    public function versionedQueryKey(string $model, array $params = []): string
    {
        $version = Cache::get('query_version_' . $model, 1);
        $hash = md5(json_encode($params));
        return 'query_' . $model . '_v' . $version . '_' . $hash;
    }
}