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
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ─── STATS CARDS ───
        $totalOrders = Order::count();
        $paidOrders = Order::where('payment_status', 'paid')->count();
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $failedOrders = Order::where('payment_status', 'failed')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('amount');
        $totalRegistrations = EventRegistration::count();

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

        $stats = [
            'total_books' => Book::count(),
            'total_events' => Event::count(),
            'total_registrations' => $totalRegistrations,
            'total_baptisms' => BaptismRequest::count(),
            'total_messages' => ContactMessage::count(),
            'total_invites' => InviteRequest::count(),
            'pending_baptisms' => BaptismRequest::where('status', 'pending')->count(),
            'unread_messages' => ContactMessage::where('status', 'unread')->count(),
            'pending_invites' => InviteRequest::where('status', 'pending')->count(),
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'paid_orders' => $paidOrders,
            'failed_orders' => $failedOrders,
            'total_revenue' => $totalRevenue,
            'orders_change' => $this->calculatePercentageChange($previousOrders, $currentOrders),
            'revenue_change' => $this->calculatePercentageChange($previousRevenue, $currentRevenue),
            'registrations_change' => $this->calculatePercentageChange($previousRegistrations, $currentRegistrations),
            'pending_change' => $this->calculatePercentageChange($previousPendingOrders, $currentPendingOrders),
            'pending_percentage' => $totalOrders > 0 ? round(($pendingOrders / $totalOrders) * 100, 1) : 0,
            'paid_percentage' => $totalOrders > 0 ? round(($paidOrders / $totalOrders) * 100, 1) : 0,
            'failed_percentage' => $totalOrders > 0 ? round(($failedOrders / $totalOrders) * 100, 1) : 0,
        ];

        // ─── GET DATE RANGE FOR CHARTS ───
        $revenueRange = $request->get('revenue_range', 'daily');
        $revenueStartDate = $request->get('revenue_start_date');
        $revenueEndDate = $request->get('revenue_end_date');
        
        $ordersRange = $request->get('orders_range', 'daily');
        $ordersStartDate = $request->get('orders_start_date');
        $ordersEndDate = $request->get('orders_end_date');

        list($revenueLabels, $revenueData, $revenueStart, $revenueEnd) = $this->getChartData(
            $revenueRange, $revenueStartDate, $revenueEndDate
        );

        list($ordersLabels, $ordersData, $ordersStart, $ordersEnd) = $this->getChartData(
            $ordersRange, $ordersStartDate, $ordersEndDate
        );

        $hasRevenueData = collect($revenueData)->sum() > 0;
        $hasOrdersData = collect($ordersData)->sum() > 0;

        // ─── UPCOMING EVENTS ───
        $upcomingEvents = Event::where('is_past', false)
            ->where('date', '>=', Carbon::today())
            ->orderBy('date')
            ->limit(6)
            ->get()
            ->map(function($event) {
                $registered = $event->registrations()->count();
                $capacity = $event->capacity ?? 0;
                return [
                    'event' => $event,
                    'registered' => $registered,
                    'capacity' => $capacity,
                    'percentage' => $capacity > 0 ? round(($registered / $capacity) * 100, 1) : 0,
                    'status' => $capacity > 0 && $registered >= $capacity ? 'full' : 'open',
                ];
            });

        // ─── TOP BOOKS ───
        $topBooks = Order::where('payment_status', 'paid')
            ->selectRaw('book_id, count(*) as total_orders, sum(amount) as total_revenue')
            ->with('book')
            ->groupBy('book_id')
            ->orderBy('total_orders', 'desc')
            ->limit(5)
            ->get();

        // ─── RECENT ACTIVITY (Limit to 3 each) ───
        $recentOrders = Order::with('book')->orderBy('created_at', 'desc')->limit(3)->get();
        $recentRegistrations = EventRegistration::with('event')->orderBy('created_at', 'desc')->limit(3)->get();
        $recentBaptisms = BaptismRequest::orderBy('created_at', 'desc')->limit(3)->get();
        $recentMessages = ContactMessage::orderBy('created_at', 'desc')->limit(3)->get();

        return view('admin.dashboard', compact(
            'stats',
            'revenueLabels',
            'revenueData',
            'revenueStart',
            'revenueEnd',
            'revenueRange',
            'ordersLabels',
            'ordersData',
            'ordersStart',
            'ordersEnd',
            'ordersRange',
            'hasRevenueData',
            'hasOrdersData',
            'topBooks',
            'recentOrders',
            'recentRegistrations',
            'recentBaptisms',
            'recentMessages',
            'upcomingEvents'
        ));
    }

    /* ─── GET CHART DATA ─── */
    private function getChartData($range, $startDate, $endDate)
    {
        if ($range === 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($endDate)->endOfDay();
        } else {
            switch ($range) {
                case 'weekly':
                    $start = Carbon::now()->startOfWeek();
                    $end = Carbon::now()->endOfWeek();
                    break;
                case 'monthly':
                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfMonth();
                    break;
                case 'daily':
                default:
                    $start = Carbon::now()->startOfMonth();
                    $end = Carbon::now()->endOfDay();
                    break;
            }
        }

        $labels = [];
        $data = [];

        $days = $start->diffInDays($end) + 1;

        if ($days > 31) {
            $months = $start->diffInMonths($end) + 1;
            for ($i = 0; $i < $months; $i++) {
                $date = $start->copy()->addMonths($i);
                $monthStart = $date->copy()->startOfMonth();
                $monthEnd = $date->copy()->endOfMonth();

                $labels[] = $date->format('M Y');
                $data[] = Order::where('payment_status', 'paid')
                    ->whereBetween('created_at', [$monthStart, $monthEnd])
                    ->sum('amount');
            }
        } else {
            for ($i = 0; $i < $days; $i++) {
                $date = $start->copy()->addDays($i);
                $dayStart = $date->copy()->startOfDay();
                $dayEnd = $date->copy()->endOfDay();

                $labels[] = $date->format('d M');
                $data[] = Order::where('payment_status', 'paid')
                    ->whereBetween('created_at', [$dayStart, $dayEnd])
                    ->sum('amount');
            }
        }

        return [$labels, $data, $start, $end];
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