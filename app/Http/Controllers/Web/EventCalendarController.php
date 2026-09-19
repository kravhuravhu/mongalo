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

    /* ─── CALENDAR PAGE ─── */
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $currentDate = Carbon::create($year, $month, 1);
        $previousMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // ─── GET EVENTS FOR MONTH ───
        $events = $this->getMonthEvents($currentDate);

        // ─── GROUP BY DATE ───
        $eventsByDate = $this->groupEventsByDate($events);

        // ─── BUILD GRID (SUNDAY START) ───
        $calendarData = $this->buildCalendarGrid($currentDate, $eventsByDate);

        // ─── UPCOMING ───
        $upcomingEvents = $this->getUpcomingEvents();

        return view('public.events.v150.calendar', compact(
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

    /* ─── JSON MONTH DATA (AJAX) ─── */
    public function monthData(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);

        $currentDate = Carbon::create($year, $month, 1);
        $previousMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // ─── GET EVENTS FOR MONTH ───
        $events = $this->getMonthEvents($currentDate);
        $eventsByDate = $this->groupEventsByDate($events);
        $calendarData = $this->buildCalendarGrid($currentDate, $eventsByDate);

        // ─── HAS ANY EVENTS THIS MONTH ───
        $hasAnyEvents = false;
        foreach ($calendarData['weeks'] as $week) {
            if (!is_array($week)) continue;
            foreach ($week as $day) {
                if (is_array($day) && !empty($day['has_events'])) {
                    $hasAnyEvents = true;
                    break 2;
                }
            }
        }

        return response()->json([
            'success' => true,
            'weeks' => $calendarData['weeks'],
            'month_label' => $currentDate->format('F Y'),
            'month_short' => $currentDate->format('M Y'),
            'has_events' => $hasAnyEvents,
            'prev' => [
                'month' => $previousMonth->month,
                'year' => $previousMonth->year,
            ],
            'next' => [
                'month' => $nextMonth->month,
                'year' => $nextMonth->year,
            ],
        ]);
    }

    /* ─── GET EVENTS FOR MONTH (CACHED) ─── */
    protected function getMonthEvents(Carbon $currentDate)
    {
        $cacheKey = $this->cacheService->key('calendar_events', [
            'month' => $currentDate->month,
            'year' => $currentDate->year,
        ]);

        return $this->cacheService->rememberClosure($cacheKey, function () use ($currentDate) {
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
                        'price' => (float) $event->price,
                        'registrations' => $event->registrations()->count(),
                        'capacity' => $event->capacity,
                        'type' => $this->getEventType($event->title),
                        'color' => $this->getEventColor($event->title),
                        'description' => $event->description,
                    ];
                })
                ->toArray();
        });
    }

    /* ─── GET EVENTS BY DATE (LEGACY ENDPOINT) ─── */
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

        $events = Event::where('is_past', false)
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
                    'price' => (float) $event->price,
                    'type' => $this->getEventType($event->title),
                    'color' => $this->getEventColor($event->title),
                    'description' => $event->description,
                ];
            })
            ->toArray();

        return response()->json([
            'success' => true,
            'date' => $carbonDate->format('l, F d, Y'),
            'events' => $events,
        ]);
    }

    /* ─── BUILD CALENDAR GRID (SUNDAY START) ─── */
    protected function buildCalendarGrid(Carbon $currentDate, array $eventsByDate): array
    {
        $daysInMonth = $currentDate->daysInMonth;

        // ─── SUNDAY START (0 = Sunday in Carbon) ───
        $firstDayOfWeek = $currentDate->copy()->startOfMonth()->dayOfWeek;

        $weeks = [];
        $currentWeek = [];

        // ─── PAD START OF MONTH ───
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $currentWeek[] = null;
        }

        // ─── ADD DAYS ───
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = $currentDate->copy()->day($day);
            $dateKey = $date->toDateString();

            $currentWeek[] = [
                'day' => $day,
                'date' => $dateKey,
                'is_today' => $date->isToday(),
                'is_past' => $date->isPast() && !$date->isToday(),
                'has_events' => isset($eventsByDate[$dateKey]) && count($eventsByDate[$dateKey]) > 0,
                'events' => $eventsByDate[$dateKey] ?? [],
                'event_count' => isset($eventsByDate[$dateKey]) ? count($eventsByDate[$dateKey]) : 0,
            ];

            // ─── WEEK FULL ───
            if (count($currentWeek) === 7) {
                $weeks[] = $currentWeek;
                $currentWeek = [];
            }
        }

        // ─── PAD END OF MONTH ───
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

    /* ─── GROUP EVENTS BY DATE ─── */
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

    /* ─── UPCOMING EVENTS FOR SIDEBAR ─── */
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

        if ($result instanceof \Illuminate\Support\Collection) {
            return $result->toArray();
        }

        return is_array($result) ? $result : [];
    }

    /* ─── EVENT TYPE FROM TITLE ─── */
    protected function getEventType(string $title): string
    {
        $lower = strtolower($title);

        if (str_contains($lower, 'conference')) return 'Conference';
        if (str_contains($lower, 'revival')) return 'Revival';
        if (str_contains($lower, 'baptism')) return 'Baptism';
        if (str_contains($lower, 'prayer')) return 'Prayer';
        if (str_contains($lower, 'worship')) return 'Worship';
        if (str_contains($lower, 'gathering')) return 'Gathering';
        if (str_contains($lower, 'service')) return 'Service';
        if (str_contains($lower, 'workshop')) return 'Workshop';
        if (str_contains($lower, 'retreat')) return 'Retreat';

        return 'Event';
    }

    /* ─── EVENT COLOR FROM TYPE ─── */
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