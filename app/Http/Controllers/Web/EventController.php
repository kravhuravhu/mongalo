<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRegistrationRequest;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Services\PhoneService;
use Carbon\Carbon;

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

    public function register(EventRegistrationRequest $request)
    {
        $validated = $request->validated();

        $event = Event::findOrFail($validated['event_id']);

        // Format phone number
        $validated['phone'] = $this->phoneService->formatE164($validated['phone']);

        // ─── CHECK IF EVENT IS FREE ───
        $isFree = $event->is_free ?? true;
        $amount = $event->price ?? 0;

        $registration = EventRegistration::create([
            'event_id' => $event->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'registration_id' => EventRegistration::generateRegistrationId(),
            'payment_status' => $isFree ? 'free' : 'pending',
        ]);

        // ─── BUILD RESPONSE ───
        $response = [
            'success' => true,
            'registration_id' => $registration->registration_id,
            'show_whatsapp' => true,
        ];

        if ($isFree) {
            $response['message'] = 'Registration successful! You are registered for this event.';
            $response['is_free'] = true;
        } else {
            $response['message'] = 'Registration successful! Please use the banking details below to complete your payment.';
            $response['is_free'] = false;
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