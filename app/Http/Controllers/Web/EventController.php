<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRegistrationRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\PhoneService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected PhoneService $phoneService;

    public function __construct(PhoneService $phoneService)
    {
        $this->phoneService = $phoneService;
    }

    public function index()
    {
        $today = Carbon::today();

        $upcomingEvents = Event::where('date', '>=', $today)
            ->orderBy('date')
            ->get();
            
        $pastEvents = Event::where('date', '<', $today)
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
        // ─── VALIDATE ───
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
        ]);

        // ─── FIND EVENT ───
        $event = Event::findOrFail($request->event_id);

        // ─── CHECK FREE/PAID ───
        $isFree = $event->is_free ?? true;
        $amount = $event->price ?? 0;

        // ─── CREATE REGISTRATION ───
        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'registration_id' => EventRegistration::generateRegistrationId(),
            'payment_status' => $isFree ? 'free' : 'pending',
        ]);

        // ─── BUILD RESPONSE ───
        $response = [
            'success' => true,
            'registration_id' => $registration->registration_id,
            'show_whatsapp' => true,
            'event_title' => $event->title,
            'event_description' => $event->description,
            'event_location' => $event->location,
            'event_date' => $event->date->format('Y-m-d'),
            'event_time' => $event->time,
            'is_free' => $isFree,
            'message' => $isFree 
                ? 'Registration successful! You are registered for this event.' 
                : 'Registration successful! Please complete payment using the details below.',
        ];

        if (!$isFree) {
            $response['amount'] = $amount;
            $response['banking_details'] = [
                'bank' => config('app.bank_name', 'Nedbank'),
                'account_name' => config('app.bank_account_name', 'The Collective'),
                'account_number' => config('app.bank_account_number', '1234567890'),
                'branch_code' => config('app.bank_branch_code', '198765'),
                'reference' => $registration->registration_id,
            ];
        }

        return response()->json($response);
    }
}