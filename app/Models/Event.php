<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Event extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'is_past',
        'sort_order',
    ];

    protected $casts = [
        'is_past' => 'boolean',
        'date' => 'date',
        'capacity' => 'integer',
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
}