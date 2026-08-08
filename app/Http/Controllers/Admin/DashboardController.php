<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Event;
use App\Models\BaptismRequest;
use App\Models\ContactMessage;
use App\Models\InviteRequest;
use App\Models\EventRegistration;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // ─── STATS CARDS ───
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
            // ─── ORDERS ───
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'failed_orders' => Order::where('payment_status', 'failed')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('amount'),
        ];

        // ─── MONTHLY REVENUE CHART DATA ───
        $monthlyRevenue = [];
        $monthlyOrders = [];
        $months = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();

            $months[] = $date->format('M');
            $monthlyRevenue[] = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            $monthlyOrders[] = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }

        // ─── TOP BOOKS ───
        $topBooks = Order::where('payment_status', 'paid')
            ->selectRaw('book_id, count(*) as total_orders, sum(amount) as total_revenue')
            ->with('book')
            ->groupBy('book_id')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();

        // ─── RECENT ACTIVITY ───
        $recentOrders = Order::with('book')->orderBy('created_at', 'desc')->limit(5)->get();
        $recentRegistrations = EventRegistration::with('event')->orderBy('created_at', 'desc')->limit(5)->get();
        $recentBaptisms = BaptismRequest::orderBy('created_at', 'desc')->limit(5)->get();
        $recentMessages = ContactMessage::orderBy('created_at', 'desc')->limit(5)->get();

        // ─── UPCOMING EVENTS ───
        $upcomingEvents = Event::where('is_past', false)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'monthlyRevenue',
            'monthlyOrders',
            'months',
            'topBooks',
            'recentOrders',
            'recentRegistrations',
            'recentBaptisms',
            'recentMessages',
            'upcomingEvents'
        ));
    }
}