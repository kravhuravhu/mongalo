<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\InviteRequest;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function index()
    {
        return view('public.invite.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
            'event_name' => 'required|max:255',
            'event_date' => 'required|date|after:today',
            'location' => 'required|max:255',
            'expected_attendance' => 'nullable|integer|min:1',
            'message' => 'nullable',
        ]);

        InviteRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
            'location' => $request->location,
            'expected_attendance' => $request->expected_attendance,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('invite')->with('success', 'Your invitation request has been sent. Arthur will respond within 48 hours!');
    }
}