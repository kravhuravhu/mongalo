<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Event;
use App\Models\BaptismRequest;
use App\Models\ContactMessage;
use App\Models\InviteRequest;
use App\Models\EventRegistration;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_events' => Event::count(),
            'total_registrations' => EventRegistration::count(),
            'total_baptisms' => BaptismRequest::count(),
            'total_messages' => ContactMessage::count(),
            'total_invites' => InviteRequest::count(),
            'pending_baptisms' => BaptismRequest::where('status', 'pending')->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'pending_invites' => InviteRequest::where('status', 'pending')->count(),
        ];

        $recentEvents = Event::orderBy('date', 'desc')->limit(5)->get();
        $recentRegistrations = EventRegistration::with('event')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentRegistrations'));
    }
}