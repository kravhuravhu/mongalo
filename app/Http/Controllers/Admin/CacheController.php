<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class CacheController extends Controller
{
    public function index()
    {
        return view('admin.cache');
    }

    public function clear(Request $request)
    {
        $type = $request->get('type');

        if ($type === 'page') {
            // ─── CLEAR PAGE CACHE ───
            $keys = Cache::get('page_cache_keys', []);
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            Cache::forget('page_cache_keys');
            $message = 'Page cache cleared successfully!';
        } elseif ($type === 'query') {
            // ─── CLEAR QUERY CACHE ───
            $keys = Cache::get('query_cache_keys', []);
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            Cache::forget('query_cache_keys');
            $message = 'Query cache cleared successfully!';
        } elseif ($type === 'stats') {
            // ─── CLEAR STATS CACHE ───
            $keys = Cache::get('stats_cache_keys', []);
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            Cache::forget('stats_cache_keys');
            $message = 'Stats cache cleared successfully!';
        } else {
            // ─── CLEAR ALL CACHE ───
            Cache::flush();
            Artisan::call('view:clear');
            Artisan::call('route:clear');
            Artisan::call('config:clear');
            $message = 'All cache cleared successfully!';
        }

        return redirect()->route('admin.cache.index')->with('success', $message);
    }

    public function warm()
    {
        Artisan::call('cache:warm');
        return redirect()->route('admin.cache.index')->with('success', 'Cache warmed successfully!');
    }

    public function status()
    {
        $status = [
            'driver' => config('cache.default'),
            'enabled' => env('CACHE_ENABLED', true),
            'page_cache' => env('PAGE_CACHE_ENABLED', true),
            'page_cache_ttl' => env('PAGE_CACHE_TTL', 3600),
            'query_cache' => env('QUERY_CACHE_ENABLED', true),
            'query_cache_ttl' => env('QUERY_CACHE_TTL', 3600),
            'cache_size' => $this->getCacheSize(),
        ];

        return view('admin.cache-status', compact('status'));
    }

    protected function getCacheSize(): string
    {
        $path = storage_path('framework/cache/data');
        if (!is_dir($path)) {
            return '0 KB';
        }

        $size = 0;
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $size += $file->getSize();
            }
        }

        if ($size >= 1048576) {
            return number_format($size / 1048576, 2) . ' MB';
        } elseif ($size >= 1024) {
            return number_format($size / 1024, 2) . ' KB';
        }
        return $size . ' B';
    }
}