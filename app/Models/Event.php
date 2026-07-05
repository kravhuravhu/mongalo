<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function getRegisteredCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function getDateTimeAttribute()
    {
        return $this->date->format('M d, Y') . ' at ' . \Carbon\Carbon::parse($this->time)->format('g:i A');
    }
}