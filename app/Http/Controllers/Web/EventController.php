<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegistrationConfirmation;
use App\Services\GoogleCalendarService;

class EventController extends Controller
{
    protected $calendarService;

    public function __construct(GoogleCalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index()
    {
        $upcomingEvents = Event::where('is_past', false)
            ->orderBy('date')
            ->get();

        $pastEvents = Event::where('is_past', true)
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();

        return view('public.events.index', compact('upcomingEvents', 'pastEvents'));
    }

    public function show($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        return view('public.events.show', compact('event'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
        ]);

        $event = Event::findOrFail($request->event_id);

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'registration_id' => EventRegistration::generateRegistrationId(),
        ]);

        // Generate ICS file
        $icsContent = $this->calendarService->generateICS($event, $registration);
        $calendarLink = $this->calendarService->generateEventLink($event, $registration);

        // Store registration ID in session for success message
        session()->flash('registration_id', $registration->registration_id);

        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Check your email for calendar invite.',
            'registration_id' => $registration->registration_id,
            'calendar_link' => $calendarLink,
            'show_whatsapp' => true,
        ]);
    }
}