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

        return Cache::remember($key, $ttl, $query);
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