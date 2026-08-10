<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegistrationConfirmation;
use Illuminate\Support\Facades\Log;

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
            $query->where(function($q) {
                $q->where('is_past', true)->orWhere('date', '<', Carbon::today());
            });
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('date', 'desc');

        $events = $query->paginate(20);

        // ─── GET COUNTS FOR DISPLAY ───
        $upcomingCount = Event::where('is_past', false)->where('date', '>=', Carbon::today())->count();
        $pastCount = Event::where('is_past', true)->orWhere('date', '<', Carbon::today())->count();

        // ─── AJAX REQUEST ───
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.events._table', compact('events'))->render(),
                'total' => $events->total(),
                'upcomingCount' => $upcomingCount,
                'pastCount' => $pastCount,
            ]);
        }

        return view('admin.events.index', compact('events', 'upcomingCount', 'pastCount'));
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
            'is_free' => 'boolean',
            'price' => 'nullable|numeric|min:0',
        ]);

        $isPast = $request->is_past ?? Carbon::parse($request->date)->isPast();

        $event = Event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_past' => $isPast,
            'is_free' => $request->has('is_free'),
            'price' => $request->has('is_free') ? 0 : ($request->price ?? 0),
            'sort_order' => Event::count() + 1,
        ]);

        Log::info('Event created by admin', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
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
            'is_free' => 'boolean',
            'price' => 'nullable|numeric|min:0',
        ]);

        $isPast = $request->is_past ?? Carbon::parse($request->date)->isPast();

        $event->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'capacity' => $request->capacity,
            'is_past' => $isPast,
            'is_free' => $request->has('is_free'),
            'price' => $request->has('is_free') ? 0 : ($request->price ?? 0),
        ]);

        Log::info('Event updated by admin', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully!');
    }

    public function registrations(Event $event)
    {
        if (!$event) {
            return redirect()->route('admin.events.index')->with('error', 'Event not found.');
        }
        
        // ─── LOAD REGISTRATIONS WITH EAGER LOADING ───
        $registrations = $event->registrations()
            ->with('event')  // ─── FIX: Eager load to prevent N+1 ───
            ->orderBy('created_at', 'desc')
            ->get();
        
        // ─── FALLBACK ───
        if ($registrations->count() === 0) {
            $registrations = EventRegistration::where('event_id', $event->id)
                ->with('event')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('admin.events.registrations', compact('event', 'registrations'));
    }

    public function updateRegistration(Request $request, EventRegistration $registration)
    {
        // ─── Determine new status ───
        $status = $request->input('status', 'paid');
        
        // If event is free, set to free
        if ($registration->event->is_free) {
            $status = 'free';
        }
        
        $oldStatus = $registration->payment_status;
        $registration->update([
            'payment_status' => $status,
        ]);

        Log::info('Registration status updated by admin', [
            'registration_id' => $registration->registration_id,
            'event_id' => $registration->event_id,
            'old_status' => $oldStatus,
            'new_status' => $status,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        // ─── CLEAR SESSION FOR THIS EVENT ───
        $sessionKey = 'pending_registration_' . $registration->event_id;
        if (session()->has($sessionKey)) {
            // Update session with new status instead of clearing
            $sessionData = session($sessionKey);
            $sessionData['payment_status'] = $status;
            session()->put($sessionKey, $sessionData);
            
            Log::info('Session updated for registration', [
                'session_key' => $sessionKey,
                'registration_id' => $registration->registration_id,
                'new_status' => $status,
            ]);
        }

        return redirect()->route('admin.events.registrations', $registration->event_id)
            ->with('success', 'Registration marked as ' . ucfirst($status) . '!');
    }

    public function resendConfirmation(EventRegistration $registration, Request $request)
    {
        $event = $registration->event;
        
        try {
            Mail::to($registration->email)->send(new EventRegistrationConfirmation($registration, $event));
            
            Log::info('Confirmation email resent by admin', [
                'registration_id' => $registration->registration_id,
                'email' => $registration->email,
                'admin_id' => session('admin_id'),
                'ip' => $request->ip(),
            ]);
            
            return redirect()->route('admin.events.registrations', $event->id)
                ->with('success', 'Confirmation email resent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to resend confirmation email', [
                'registration_id' => $registration->registration_id,
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
            ]);
            
            return redirect()->route('admin.events.registrations', $event->id)
                ->with('error', 'Failed to send email. Please try again.');
        }
    }

    public function destroy(Event $event, Request $request)
    {
        Log::info('Event deleted by admin', [
            'event_id' => $event->id,
            'event_title' => $event->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully!');
    }
}