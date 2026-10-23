<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = ['key', 'value', 'type', 'group'];

    // ─── PER-REQUEST MEMO ───
    protected static ?array $memoized = null;

    protected const CACHE_KEY = 'settings:all';
    protected const CACHE_TTL = 3600;

    // ─── LOAD ALL (CACHED) ───
    public static function allCached(): array
    {
        if (static::$memoized !== null) {
            return static::$memoized;
        }

        static::$memoized = Cache::remember(static::CACHE_KEY, static::CACHE_TTL, function () {
            $rows = DB::table('settings')->get();

            $out = [];
            foreach ($rows as $row) {
                $out[$row->key] = static::castValue($row->value, $row->type);
            }

            return $out;
        });

        return static::$memoized;
    }

    // ─── GET ONE ───
    public static function get(string $key, $default = null)
    {
        $all = static::allCached();
        return $all[$key] ?? $default;
    }

    // ─── SET ONE ───
    public static function set(string $key, $value, string $type = 'string', string $group = 'general'): void
    {
        \Log::info('Setting::set called', [
            'key'   => $key,
            'value' => $value,
            'type'  => $type,
            'group' => $group,
        ]);

        $stringValue = is_array($value) ? json_encode($value) : (string) $value;

        try {
            $exists = DB::selectOne(
                'SELECT `id` FROM `settings` WHERE `key` = ? LIMIT 1',
                [$key]
            );

            \Log::info('Setting::set exists check', ['key' => $key, 'exists' => (bool) $exists]);

            if ($exists) {
                DB::statement(
                    'UPDATE `settings` SET `value` = ?, `type` = ?, `group` = ?, `updated_at` = ? WHERE `key` = ?',
                    [$stringValue, $type, $group, now(), $key]
                );
                \Log::info('Setting::set updated', ['key' => $key]);
            } else {
                DB::statement(
                    'INSERT INTO `settings` (`key`, `value`, `type`, `group`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?)',
                    [$key, $stringValue, $type, $group, now(), now()]
                );
                \Log::info('Setting::set inserted', ['key' => $key]);
            }
        } catch (\Throwable $e) {
            \Log::error('Setting::set failed', [
                'key'   => $key,
                'error' => $e->getMessage(),
                'code'  => $e->getCode(),
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
            ]);
        }

        static::flushCache();
    }

    // ─── SET MANY ───
    public static function setMany(array $values): void
    {
        foreach ($values as $key => $payload) {
            if (is_array($payload) && array_key_exists('value', $payload)) {
                $value = $payload['value'];
                $type  = $payload['type']  ?? 'string';
                $group = $payload['group'] ?? 'general';
            } else {
                $value = $payload;
                $type  = 'string';
                $group = 'general';
            }

            static::set($key, $value, $type, $group);
        }
    }

    // ─── FLUSH ───
    public static function flushCache(): void
    {
        static::$memoized = null;
        Cache::forget(static::CACHE_KEY);
    }

    // ─── CAST ───
    protected static function castValue($value, string $type)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'number'  => is_numeric($value) ? (float) $value : 0,
            'json'    => json_decode($value, true) ?: [],
            default   => $value,
        };
    }
}