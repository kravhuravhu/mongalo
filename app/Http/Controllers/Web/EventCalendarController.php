<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventCalendarController extends Controller
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    /**
     * Display the event calendar
     */
    public function index(Request $request)
    {
        // ─── GET MONTH AND YEAR FROM REQUEST ───
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        // ─── CREATE CARBON DATE FOR THE SELECTED MONTH ───
        $currentDate = Carbon::create($year, $month, 1);
        $previousMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // ─── GET EVENTS FOR THE SELECTED MONTH ───
        $cacheKey = $this->cacheService->key('calendar_events', [
            'month' => $month,
            'year' => $year,
        ]);

        $events = $this->cacheService->rememberClosure($cacheKey, function () use ($currentDate) {
            $startOfMonth = $currentDate->copy()->startOfMonth();
            $endOfMonth = $currentDate->copy()->endOfMonth();

            return Event::where('is_past', false)
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->orderBy('date')
                ->orderBy('time')
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'slug' => $event->slug,
                        'date' => $event->date->toDateString(),
                        'time' => $event->time ? Carbon::parse($event->time)->format('g:i A') : null,
                        'location' => $event->location,
                        'is_free' => $event->is_free,
                        'price' => $event->price,
                        'registrations' => $event->registrations()->count(),
                        'capacity' => $event->capacity,
                        'type' => $this->getEventType($event->title),
                        'color' => $this->getEventColor($event->title),
                        'description' => $event->description,
                    ];
                })
                ->toArray();
        });

        // ─── GROUP EVENTS BY DATE ───
        $eventsByDate = $this->groupEventsByDate($events);

        // ─── BUILD CALENDAR GRID ───
        $calendarData = $this->buildCalendarGrid($currentDate, $eventsByDate);

        // ─── GET UPCOMING EVENTS ───
        $upcomingEvents = $this->getUpcomingEvents();

        return view('public.events.calendar', compact(
            'calendarData',
            'currentDate',
            'previousMonth',
            'nextMonth',
            'month',
            'year',
            'eventsByDate',
            'upcomingEvents'
        ));
    }

    /**
     * Get events for a specific date (AJAX)
     */
    public function getEventsByDate(Request $request)
    {
        $date = $request->get('date');

        if (!$date) {
            return response()->json([
                'success' => false,
                'message' => 'Date parameter is required.',
            ], 400);
        }

        $carbonDate = Carbon::parse($date);

        $cacheKey = $this->cacheService->key('calendar_events_date', [
            'date' => $date,
        ]);

        $events = $this->cacheService->rememberClosure($cacheKey, function () use ($carbonDate) {
            return Event::where('is_past', false)
                ->whereDate('date', $carbonDate->toDateString())
                ->orderBy('time')
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'slug' => $event->slug,
                        'time' => $event->time ? Carbon::parse($event->time)->format('g:i A') : null,
                        'location' => $event->location,
                        'is_free' => $event->is_free,
                        'price' => $event->price,
                        'registrations' => $event->registrations()->count(),
                        'capacity' => $event->capacity,
                        'type' => $this->getEventType($event->title),
                        'color' => $this->getEventColor($event->title),
                        'description' => $event->description,
                    ];
                })
                ->toArray();
        });

        return response()->json([
            'success' => true,
            'date' => $carbonDate->format('l, F d, Y'),
            'events' => $events,
        ]);
    }

    /**
     * Build calendar grid
     */
    protected function buildCalendarGrid(Carbon $currentDate, array $eventsByDate): array
    {
        $daysInMonth = $currentDate->daysInMonth;
        $firstDayOfWeek = $currentDate->copy()->startOfMonth()->dayOfWeek;

        // ─── ADJUST FOR MONDAY AS FIRST DAY ───
        $firstDayOfWeek = $firstDayOfWeek === 0 ? 6 : $firstDayOfWeek - 1;

        $weeks = [];
        $currentWeek = [];

        // ─── ADD EMPTY DAYS FOR START OF MONTH ───
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $currentWeek[] = null;
        }

        // ─── ADD DAYS OF THE MONTH ───
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $currentDate->copy()->day($day);
            $dateKey = $date->toDateString();

            $dayData = [
                'day' => $day,
                'date' => $dateKey,
                'is_today' => $date->isToday(),
                'is_past' => $date->isPast() && !$date->isToday(),
                'has_events' => isset($eventsByDate[$dateKey]) && count($eventsByDate[$dateKey]) > 0,
                'events' => $eventsByDate[$dateKey] ?? [],
                'event_count' => isset($eventsByDate[$dateKey]) ? count($eventsByDate[$dateKey]) : 0,
            ];

            $currentWeek[] = $dayData;

            // ─── WHEN WEEK IS FULL, ADD TO WEEKS ───
            if (count($currentWeek) === 7) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }
        }

        // ─── ADD EMPTY DAYS FOR END OF MONTH ───
        if (count($currentWeek) > 0) {
            while (count($currentWeek) < 7) {
                $currentWeek[] = null;
            }
            $weeks[] = $currentWeek;
        }

        return [
            'weeks' => $weeks,
            'month' => $currentDate->format('F'),
            'year' => $currentDate->year,
        ];
    }

    /**
     * Group events by date
     */
    protected function groupEventsByDate(array $events): array
    {
        $grouped = [];

        foreach ($events as $event) {
            $dateKey = $event['date'];

            if (!isset($grouped[$dateKey])) {
                $grouped[$dateKey] = [];
            }

            $grouped[$dateKey][] = $event;
        }

        return $grouped;
    }

    /**
     * Get upcoming events for sidebar (returns array)
     */
    protected function getUpcomingEvents(): array
    {
        $cacheKey = $this->cacheService->key('calendar_upcoming', []);

        $result = $this->cacheService->rememberClosure($cacheKey, function () {
            return Event::where('is_past', false)
                ->where('date', '>=', Carbon::today())
                ->orderBy('date')
                ->limit(5)
                ->get()
                ->map(function ($event) {
                    return [
                        'id' => $event->id,
                        'title' => $event->title,
                        'slug' => $event->slug,
                        'date' => $event->date->toDateString(),
                        'time' => $event->time ? Carbon::parse($event->time)->format('g:i A') : null,
                        'location' => $event->location,
                        'type' => $this->getEventType($event->title),
                        'color' => $this->getEventColor($event->title),
                    ];
                })
                ->toArray();
        });

        // ─── ENSURE WE RETURN AN ARRAY ───
        if ($result instanceof \Illuminate\Support\Collection) {
            return $result->toArray();
        }

        if (is_array($result)) {
            return $result;
        }

        return [];
    }

    /**
     * Get event type from title
     */
    protected function getEventType(string $title): string
    {
        $lower = strtolower($title);

        if (str_contains($lower, 'conference')) {
            return 'Conference';
        } elseif (str_contains($lower, 'revival')) {
            return 'Revival';
        } elseif (str_contains($lower, 'baptism')) {
            return 'Baptism';
        } elseif (str_contains($lower, 'prayer')) {
            return 'Prayer';
        } elseif (str_contains($lower, 'worship')) {
            return 'Worship';
        } elseif (str_contains($lower, 'gathering')) {
            return 'Gathering';
        } elseif (str_contains($lower, 'service')) {
            return 'Service';
        } elseif (str_contains($lower, 'workshop')) {
            return 'Workshop';
        } elseif (str_contains($lower, 'retreat')) {
            return 'Retreat';
        }

        return 'Event';
    }

    /**
     * Get event color based on type
     */
    protected function getEventColor(string $title): string
    {
        $type = $this->getEventType($title);

        return match ($type) {
            'Conference' => '#a67c4e',
            'Revival' => '#e67e22',
            'Baptism' => '#4A9E9E',
            'Prayer' => '#6f42c1',
            'Worship' => '#28a745',
            'Gathering' => '#e8a838',
            'Service' => '#dc3545',
            'Workshop' => '#17a2b8',
            'Retreat' => '#6c757d',
            default => '#a67c4e',
        };
    }
}