<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\CacheService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventRegistrationConfirmation;
use Illuminate\Support\Facades\Log;

class EventController extends Controller
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
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
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
        ]);

        $event = Event::findOrFail($request->event_id);

        // ─── CHECK FOR DUPLICATE REGISTRATION ───
        $existing = EventRegistration::where('event_id', $request->event_id)
            ->where('email', $request->email)
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->first();
        
        if ($existing) {
            Log::info('Duplicate registration attempt', [
                'event_id' => $request->event_id,
                'email' => $request->email,
                'existing_registration_id' => $existing->registration_id,
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'You are already registered for this event. Check your email for confirmation.',
                'existing' => true,
                'registration_id' => $existing->registration_id,
                'registration_data' => [
                    'registration_id' => $existing->registration_id,
                    'name' => $existing->name,
                    'email' => $existing->email,
                    'phone' => $existing->phone,
                    'payment_status' => $existing->payment_status,
                    'event_id' => $event->id,
                    'event_slug' => $event->slug,
                ],
            ], 409);
        }

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

        // ─── CLEAR EVENT CACHE ───
        $event->clearModelCache('event');

        // ─── SEND CONFIRMATION EMAIL ───
        try {
            Mail::to($registration->email)->send(new EventRegistrationConfirmation($registration, $event));
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
        }

        // ─── BUILD RESPONSE WITH REGISTRATION DATA ───
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
            // ─── REGISTRATION DATA FOR LOCALSTORAGE ───
            'registration_data' => [
                'registration_id' => $registration->registration_id,
                'name' => $registration->name,
                'email' => $registration->email,
                'phone' => $registration->phone,
                'amount' => $amount,
                'payment_status' => $registration->payment_status,
                'is_free' => $isFree,
                'event_id' => $event->id,
                'event_slug' => $event->slug,
                'expires_at' => now()->addHours(48)->toIso8601String(),
            ],
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
            $response['registration_data']['banking_details'] = $response['banking_details'];
        }

        Log::info('Event registration created', [
            'event_id' => $event->id,
            'registration_id' => $registration->registration_id,
            'email' => $request->email,
        ]);

        return response()->json($response);
    }

    public function clearRegistration(Request $request)
    {
        $eventId = $request->input('event_id');
        $eventSlug = $request->input('event_slug');
        
        // ─── ADD CACHE-BUSTING PARAMETER ───
        return redirect()->route('events.show', $eventSlug)
            ->with('success', 'Registration cleared. You can now register again.')
            ->with('_nocache', time());
    }
}