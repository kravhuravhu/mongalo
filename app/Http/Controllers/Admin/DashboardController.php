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
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('payment_status', 'pending')->count(),
            'paid_orders' => Order::where('payment_status', 'paid')->count(),
            'failed_orders' => Order::where('payment_status', 'failed')->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('amount'),
        ];

        // ─── ORDER STATUS BREAKDOWN (PERCENTAGES) ───
        $totalOrders = $stats['total_orders'];
        if ($totalOrders > 0) {
            $stats['paid_percentage'] = round(($stats['paid_orders'] / $totalOrders) * 100, 1);
            $stats['pending_percentage'] = round(($stats['pending_orders'] / $totalOrders) * 100, 1);
            $stats['failed_percentage'] = round(($stats['failed_orders'] / $totalOrders) * 100, 1);
        } else {
            $stats['paid_percentage'] = 0;
            $stats['pending_percentage'] = 0;
            $stats['failed_percentage'] = 0;
        }

        // ─── CURRENT PERIOD (This Month) ───
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // ─── CURRENT PERIOD COUNTS ───
        $currentOrders = Order::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $currentRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('amount');
        $currentRegistrations = EventRegistration::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])->count();
        $currentPendingOrders = Order::where('payment_status', 'pending')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // ─── PREVIOUS PERIOD COUNTS ───
        $previousOrders = Order::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        $previousRevenue = Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->sum('amount');
        $previousRegistrations = EventRegistration::whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])->count();
        $previousPendingOrders = Order::where('payment_status', 'pending')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        // ─── CALCULATE PERCENTAGE CHANGES ───
        $stats['orders_change'] = $this->calculatePercentageChange($previousOrders, $currentOrders);
        $stats['revenue_change'] = $this->calculatePercentageChange($previousRevenue, $currentRevenue);
        $stats['registrations_change'] = $this->calculatePercentageChange($previousRegistrations, $currentRegistrations);
        $stats['pending_change'] = $this->calculatePercentageChange($previousPendingOrders, $currentPendingOrders);

        // ─── CHART DATA: DAILY TRENDS FOR CURRENT MONTH ───
        $dailyRevenue = [];
        $dailyOrders = [];
        $dailyLabels = [];

        // ─── GET ALL DAYS IN CURRENT MONTH ───
        $daysInMonth = Carbon::now()->daysInMonth;
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day);
            $startOfDay = $date->copy()->startOfDay();
            $endOfDay = $date->copy()->endOfDay();

            $dailyLabels[] = $date->format('d');
            
            // ─── REVENUE FOR THIS DAY ───
            $dailyRevenue[] = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->sum('amount');
            
            // ─── ORDERS FOR THIS DAY ───
            $dailyOrders[] = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$startOfDay, $endOfDay])
                ->count();
        }

        // ─── CHECK IF DATA EXISTS ───
        $hasData = collect($dailyRevenue)->sum() > 0;
        $hasOrders = collect($dailyOrders)->sum() > 0;

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
            'dailyRevenue',
            'dailyOrders',
            'dailyLabels',
            'daysInMonth',
            'currentMonth',
            'hasData',
            'hasOrders',
            'topBooks',
            'recentOrders',
            'recentRegistrations',
            'recentBaptisms',
            'recentMessages',
            'upcomingEvents'
        ));
    }

    /* ─── CALCULATE PERCENTAGE CHANGE ─── */
    private function calculatePercentageChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        $change = (($current - $previous) / $previous) * 100;
        return round($change, 1);
    }
}