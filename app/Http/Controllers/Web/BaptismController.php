<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\BaptismRequest;
use Illuminate\Http\Request;

class BaptismController extends Controller
{
    public function index()
    {
        return view('public.baptism.index');
    }

    public function request(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|max:50',
            'location' => 'required|max:255',
            'preferred_date' => 'nullable|date|after:today',
            'message' => 'nullable',
        ]);

        BaptismRequest::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
            'preferred_date' => $request->preferred_date,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return redirect()->route('baptism')->with('success', 'Your baptism request has been submitted. We will contact you soon!');
    }
}