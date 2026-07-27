<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
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

        $isFree = $event->is_free ?? true;
        $amount = $event->price ?? 0;

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
        ];

        if ($isFree) {
            $response['message'] = 'Registration successful! You are registered for this event.';
            $response['is_free'] = true;
        } else {
            // show banking details
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