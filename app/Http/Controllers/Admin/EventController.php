<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // ─── SEARCH ───
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // ─── FILTER ───
        if ($request->filter === 'upcoming') {
            $query->where('is_past', false)->where('date', '>=', Carbon::today());
        } elseif ($request->filter === 'past') {
            $query->where('is_past', true)->orWhere('date', '<', Carbon::today());
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('date', 'desc');

        $events = $query->paginate(20);

        // ─── AJAX REQUEST ───
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.events._table', compact('events'))->render(),
                'total' => $events->total(),
            ]);
        }

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|max:255',
            'capacity' => 'nullable|integer|min:1',
            'is_past' => 'boolean',
        ]);

        Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_past' => $request->is_past ?? false,
            'sort_order' => Event::count() + 1,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'required|max:255',
            'capacity' => 'nullable|integer|min:1',
            'is_past' => 'boolean',
        ]);

        $event->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_past' => $request->is_past ?? false,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function registrations(Event $event)
    {
        // redirect back
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event not found.');
        }
        
        $registrations = $event->registrations()->orderBy('created_at', 'desc')->get();
        
        return view('admin.events.registrations', compact('event', 'registrations'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }
}