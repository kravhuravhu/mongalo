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
        'category',
        'poster_image',
        'recurrence',
        'recurrence_interval',
        'recurrence_weekdays',
        'recurrence_ends_on',
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
        'recurrence_interval' => 'integer',
        'recurrence_weekdays' => 'array',
        'recurrence_ends_on' => 'date',
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

    // ─── iN: CATEGORY + POSTER ───
    public function getCategoryLabelAttribute()
    {
        return config('in.brands.community.event_categories.' . $this->category . '.label', 'Event');
    }
    
    public function getPosterUrlAttribute()
    {
        return $this->poster_image ? secure_asset('storage/events/posters/' . $this->poster_image) : null;
    }

    // ─── iN: RECURRENCE ───
    public function getIsRecurringAttribute()
    {
        return $this->recurrence && $this->recurrence !== 'none';
    }

    /* ─── NEXT OCCURRENCES FROM A DATE (INCLUDING THAT DATE) ─── */
    public function occurrencesFrom(Carbon $from, int $limit = 8): array
    {
        $start = $this->date->copy()->startOfDay();
        $from = $from->copy()->startOfDay();
        $until = $this->recurrence_ends_on ? $this->recurrence_ends_on->copy()->endOfDay() : null;
        if (!$this->is_recurring) {
            return $start->gte($from) ? [$start] : [];
        }

        $interval = max(1, (int) $this->recurrence_interval);
        $out = [];
        if ($this->recurrence === 'weekly') {
            $weekdays = $this->recurrence_weekdays ?: [$start->dayOfWeek];
            $startWeek = $start->copy()->startOfWeek(Carbon::SUNDAY);
            $base = $start->gt($from) ? $start->copy() : $from->copy();
            for ($i = 0; $i < 2200 && count($out) < $limit; $i++) {
                $day = $base->copy()->addDays($i);
                if ($until && $day->gt($until)) {
                    break;
                }
                $weekIndex = (int) floor(abs((int) $startWeek->diffInDays($day->copy()->startOfWeek(Carbon::SUNDAY))) / 7);
                if ($weekIndex % $interval === 0 && in_array($day->dayOfWeek, $weekdays)) {
                    $out[] = $day;
                }
            }
            return $out;
        }
        for ($k = 0; $k < 3000 && count($out) < $limit; $k++) {
            $day = match ($this->recurrence) {
                'daily' => $start->copy()->addDays($k * $interval),
                'monthly' => $start->copy()->addMonthsNoOverflow($k * $interval),
                'yearly' => $start->copy()->addYearsNoOverflow($k * $interval),
                default => null,
            };
            if (!$day || ($until && $day->gt($until))) {
                break;
            }
            if ($day->gte($from)) {
                $out[] = $day;
            }
        }
        return $out;
    }
    public function nextOccurrence()
    {
        return $this->occurrencesFrom(Carbon::today(), 1)[0] ?? null;
    }
    public function isOccurrence(string $date): bool
    {
        $day = Carbon::parse($date)->startOfDay();
        $first = $this->occurrencesFrom($day, 1)[0] ?? null;
        return $first !== null && $first->isSameDay($day);
    }

    /* ─── HUMAN LABEL: "Every Friday", "Monthly on the 15th" ─── */
    public function getRecurrenceLabelAttribute()
    {
        if (!$this->is_recurring) {
            return null;
        }
        
        $n = max(1, (int) $this->recurrence_interval);
        $names = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        switch ($this->recurrence) {
            case 'daily':
                return $n === 1 ? 'Every day' : "Every {$n} days";
            case 'weekly':
                $days = collect($this->recurrence_weekdays ?: [$this->date->dayOfWeek])
                    ->map(fn ($d) => $names[$d])->join(', ', ' & ');
                return $n === 1 ? "Every {$days}" : "Every {$n} weeks on {$days}";
            case 'monthly':
                $day = $this->date->format('jS');
                return $n === 1 ? "Monthly on the {$day}" : "Every {$n} months on the {$day}";
            case 'yearly':
                $when = $this->date->format('j F');
                return $n === 1 ? "Every year on {$when}" : "Every {$n} years on {$when}";
        }

        return null;
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
        $ids = $instance->cachedQuery($key, function () {
            return self::where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->pluck('id')
                ->all();
        });
        if (empty($ids)) {
            return self::where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->get();
        }
        return self::whereIn('id', $ids)->orderBy('date')->get();
    }

    public static function getCachedEventsWithRegistrations()
    {
        $instance = new static();
        $key = $instance->versionedQueryKey('event', ['with_registrations' => true]);
        $ids = $instance->cachedQuery($key, function () {
            return self::where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->limit(6)
                ->pluck('id')
                ->all();
        });
        if (empty($ids)) {
            return collect();
        }
        return self::with('registrations')
            ->whereIn('id', $ids)
            ->orderBy('date')
            ->get()
            ->map(function ($event) {
                $registered = $event->registrations()->count();
                $capacity   = $event->capacity ?? 0;
                return [
                    'event' => $event,
                    'registered' => $registered,
                    'capacity' => $capacity,
                    'percentage' => $capacity > 0 ? round(($registered / $capacity) * 100, 1) : 0,
                    'status' => $capacity > 0 && $registered >= $capacity ? 'full' : 'open',
                ];
            });
    }
}