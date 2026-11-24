<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $brand = config('in.brands.community');
        $today = Carbon::today();

        // ─── LIVE EVENTS: UPCOMING OR STILL-REPEATING ───
        $events = Event::where('is_past', false)
            ->where(function ($query) use ($today) {
                $query->where('date', '>=', $today)
                    ->orWhere(function ($recurring) use ($today) {
                        $recurring->where('recurrence', '!=', 'none')
                            ->where(function ($ends) use ($today) {
                                $ends->whereNull('recurrence_ends_on')
                                    ->orWhere('recurrence_ends_on', '>=', $today);
                            });
                    });
            })
            ->get();
        
        // ─── ONE PROGRAM PER EVENT, WITH ITS NEXT DATES ───
        $programs = $events->map(function ($event) use ($today) {
            
            $occurrences = $event->occurrencesFrom($today, 8);
            
            if (empty($occurrences)) {
                return null;
            }

            return [
                'event' => $event,
                'next' => $occurrences[0],
                'occurrences' => $occurrences,
            ];
        })
            ->filter()
            ->sortBy(fn ($program) => $program['next']->format('Y-m-d') . ' ' . ($program['event']->time ?: '00:00'))
            ->values();

        // ─── HERO POSTER: NEXT EVENT THAT HAS ONE ───
        $posterProgram = $programs->first(fn ($program) => (bool) $program['event']->poster_image);
        
        // ─── TABS: PINNED CATEGORIES + ANY CATEGORY WITH EVENTS ───
        $tabs = collect($brand['event_categories'])->filter(function ($category, $key) use ($programs) {
            return ($category['pinned'] ?? false)
                || $programs->contains(fn ($program) => $program['event']->category === $key);
        });

        $category = $request->get('cat', 'all');
        if ($category !== 'all' && $category !== 'invite' && !$tabs->has($category)) {
            $category = 'all';
        }
        
        return view('public.community.v160.index', compact('brand', 'programs', 'posterProgram', 'tabs', 'category'));
    }
}