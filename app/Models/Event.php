<?php

namespace App\Models;

use App\Traits\QueryCacheable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    use QueryCacheable;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'is_past',
        'is_free',
        'price',
        'sort_order',
    ];

    protected $casts = [
        'is_past' => 'boolean',
        'is_free' => 'boolean',
        'date' => 'date',
        'capacity' => 'integer',
        'price' => 'decimal:2',
    ];

    protected $table = 'events';

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        // ─── CLEAR CACHE ON SAVE/DELETE ───
        static::saved(function ($event) {
            $event->clearModelCache('event');
        });

        static::deleted(function ($event) {
            $event->clearModelCache('event');
        });
    }

    // ─── RELATIONSHIP ───
    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    // ─── ATTRIBUTES ───
    public function getRegisteredCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function getDateTimeAttribute()
    {
        if ($this->date && $this->time) {
            return $this->date->format('M d, Y') . ' at ' . Carbon::parse($this->time)->format('g:i A');
        }
        return 'Date TBD';
    }

    public function getFormattedDateAttribute()
    {
        if ($this->date) {
            return $this->date->format('M d, Y');
        }
        return 'Date TBD';
    }

    public function getFormattedTimeAttribute()
    {
        if ($this->time) {
            return Carbon::parse($this->time)->format('g:i A');
        }
        return 'Time TBD';
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->is_free) {
            return 'Free';
        }
        return $this->price > 0 ? 'R' . number_format($this->price, 2) : 'Free';
    }

    /* ─── SCOPES WITH CACHE ─── */
    public static function getCachedUpcomingEvents()
    {
        $instance = new static();
        $key = $instance->versionedQueryKey('event', ['upcoming' => true]);
        
        return $instance->cachedQuery($key, function () {
            return self::where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->get();
        });
    }

    public static function getCachedEventsWithRegistrations()
    {
        $instance = new static();
        $key = $instance->versionedQueryKey('event', ['with_registrations' => true]);
        
        return $instance->cachedQuery($key, function () {
            return self::with('registrations')
                ->where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->limit(6)
                ->get()
                ->map(function($event) {
                    $registered = $event->registrations()->count();
                    $capacity = $event->capacity ?? 0;
                    return [
                        'event' => $event,
                        'registered' => $registered,
                        'capacity' => $capacity,
                        'percentage' => $capacity > 0 ? round(($registered / $capacity) * 100, 1) : 0,
                        'status' => $capacity > 0 && $registered >= $capacity ? 'full' : 'open',
                    ];
                });
        });
    }
}