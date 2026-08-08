@extends('admin.layouts.admin')

@section('title', 'Dashboard · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')

<div class="dashboard">

    {{-- ─── STATS CARDS ─── --}}
    <div class="dashboard__stats-grid">
        <div class="dashboard__stat-card">
            <div class="dashboard__stat-icon" style="background: rgba(166, 124, 78, 0.08);">
                <i class="fas fa-shopping-cart" style="color: #a67c4e;"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['total_orders'] }}</span>
                <span class="dashboard__stat-label">Total Orders</span>
                <span class="dashboard__stat-change dashboard__stat-change--up">
                    <i class="fas fa-arrow-up"></i> +12%
                </span>
            </div>
        </div>

        <div class="dashboard__stat-card">
            <div class="dashboard__stat-icon" style="background: rgba(40, 167, 69, 0.08);">
                <i class="fas fa-credit-card" style="color: #28a745;"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">R{{ number_format($stats['total_revenue'], 0) }}</span>
                <span class="dashboard__stat-label">Total Revenue</span>
                <span class="dashboard__stat-change dashboard__stat-change--up">
                    <i class="fas fa-arrow-up"></i> +8%
                </span>
            </div>
        </div>

        <div class="dashboard__stat-card">
            <div class="dashboard__stat-icon" style="background: rgba(232, 168, 56, 0.08);">
                <i class="fas fa-clock" style="color: #e8a838;"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['pending_orders'] }}</span>
                <span class="dashboard__stat-label">Pending Orders</span>
                <span class="dashboard__stat-change dashboard__stat-change--down">
                    <i class="fas fa-arrow-down"></i> -3%
                </span>
            </div>
        </div>

        <div class="dashboard__stat-card">
            <div class="dashboard__stat-icon" style="background: rgba(74, 158, 158, 0.08);">
                <i class="fas fa-users" style="color: #4A9E9E;"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['total_registrations'] }}</span>
                <span class="dashboard__stat-label">Registrations</span>
                <span class="dashboard__stat-change dashboard__stat-change--up">
                    <i class="fas fa-arrow-up"></i> +5%
                </span>
            </div>
        </div>
    </div>

    {{-- ─── CHARTS ROW ─── --}}
    <div class="dashboard__charts-row" id="chartsContainer">
        <div class="dashboard__chart-card dashboard__chart-card--revenue">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-chart-line"></i> Revenue Overview</h3>
                <span class="dashboard__chart-period">Last 12 Months</span>
            </div>
            <div class="dashboard__chart-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="dashboard__chart-card dashboard__chart-card--orders">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-shopping-bag"></i> Order Trends</h3>
                <span class="dashboard__chart-period">Monthly Orders</span>
            </div>
            <div class="dashboard__chart-body">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ─── TOP BOOKS & QUICK STATS ─── --}}
    <div class="dashboard__two-col">
        {{-- TOP BOOKS --}}
        <div class="dashboard__card">
            <div class="dashboard__card-header">
                <h3><i class="fas fa-crown"></i> Top Selling Books</h3>
                <a href="{{ route('admin.books.index') }}" class="dashboard__card-link">View All</a>
            </div>
            <div class="dashboard__card-body">
                @if($topBooks->count() > 0)
                    <div class="dashboard__top-books">
                        @foreach($topBooks as $index => $book)
                            <div class="dashboard__top-book">
                                <span class="dashboard__top-book-rank">{{ $index + 1 }}</span>
                                <div class="dashboard__top-book-info">
                                    <span class="dashboard__top-book-title">{{ $book->book->title ?? 'N/A' }}</span>
                                    <span class="dashboard__top-book-meta">
                                        {{ $book->total_orders }} orders · R{{ number_format($book->total_revenue, 2) }}
                                    </span>
                                </div>
                                <div class="dashboard__top-book-bar">
                                    <div class="dashboard__top-book-bar-fill" style="width: {{ $index === 0 ? 100 : ($book->total_orders / $topBooks->first()->total_orders * 100) }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="dashboard__empty">No books have been sold yet.</p>
                @endif
            </div>
        </div>

        {{-- ORDER STATUS --}}
        <div class="dashboard__card">
            <div class="dashboard__card-header">
                <h3><i class="fas fa-chart-pie"></i> Order Status</h3>
                <span class="dashboard__card-badge">{{ $stats['total_orders'] }} Total</span>
            </div>
            <div class="dashboard__card-body">
                <div class="dashboard__order-status">
                    <div class="dashboard__order-status-item">
                        <div class="dashboard__order-status-info">
                            <span class="dashboard__order-status-label">
                                <span class="dashboard__order-status-dot dashboard__order-status-dot--paid"></span>
                                Paid
                            </span>
                            <span class="dashboard__order-status-number">{{ $stats['paid_orders'] }}</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--paid" style="width: {{ $stats['total_orders'] > 0 ? ($stats['paid_orders'] / $stats['total_orders'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>

                    <div class="dashboard__order-status-item">
                        <div class="dashboard__order-status-info">
                            <span class="dashboard__order-status-label">
                                <span class="dashboard__order-status-dot dashboard__order-status-dot--pending"></span>
                                Pending
                            </span>
                            <span class="dashboard__order-status-number">{{ $stats['pending_orders'] }}</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--pending" style="width: {{ $stats['total_orders'] > 0 ? ($stats['pending_orders'] / $stats['total_orders'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>

                    <div class="dashboard__order-status-item">
                        <div class="dashboard__order-status-info">
                            <span class="dashboard__order-status-label">
                                <span class="dashboard__order-status-dot dashboard__order-status-dot--failed"></span>
                                Failed
                            </span>
                            <span class="dashboard__order-status-number">{{ $stats['failed_orders'] }}</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--failed" style="width: {{ $stats['total_orders'] > 0 ? ($stats['failed_orders'] / $stats['total_orders'] * 100) : 0 }}%;"></div>
                        </div>
                    </div>
                </div>

                <div class="dashboard__quick-actions">
                    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="dashboard__quick-action">
                        <i class="fas fa-clock"></i>
                        <span>{{ $stats['pending_orders'] }} Pending</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="dashboard__quick-action">
                        <i class="fas fa-list"></i>
                        <span>All Orders</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── RECENT ACTIVITY ─── --}}
    <div class="dashboard__activity">
        <div class="dashboard__activity-header">
            <h3><i class="fas fa-bolt"></i> Recent Activity</h3>
            <span class="dashboard__activity-time">Last 5 items</span>
        </div>

        <div class="dashboard__activity-tabs">
            <button class="dashboard__activity-tab dashboard__activity-tab--active" data-tab="orders">
                <i class="fas fa-shopping-cart"></i> Orders
            </button>
            <button class="dashboard__activity-tab" data-tab="registrations">
                <i class="fas fa-users"></i> Registrations
            </button>
            <button class="dashboard__activity-tab" data-tab="baptisms">
                <i class="fas fa-water"></i> Baptisms
            </button>
            <button class="dashboard__activity-tab" data-tab="messages">
                <i class="fas fa-envelope"></i> Messages
            </button>
        </div>

        <div class="dashboard__activity-content">

            {{-- ORDERS --}}
            <div class="dashboard__activity-list dashboard__activity-list--active" id="activity-orders">
                @forelse($recentOrders as $order)
                    <div class="dashboard__activity-item">
                        <div class="dashboard__activity-icon dashboard__activity-icon--order">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="dashboard__activity-info">
                            <span class="dashboard__activity-title">
                                New order <strong>#{{ $order->order_number }}</strong>
                                <span class="dashboard__activity-badge badge badge-{{ $order->payment_status }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </span>
                            <span class="dashboard__activity-desc">
                                {{ $order->buyer_name }} purchased "{{ $order->book->title ?? 'N/A' }}"
                            </span>
                            <span class="dashboard__activity-time-ago">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="dashboard__empty">No recent orders.</p>
                @endforelse
            </div>

            {{-- REGISTRATIONS --}}
            <div class="dashboard__activity-list" id="activity-registrations">
                @forelse($recentRegistrations as $reg)
                    <div class="dashboard__activity-item">
                        <div class="dashboard__activity-icon dashboard__activity-icon--registration">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="dashboard__activity-info">
                            <span class="dashboard__activity-title">
                                {{ $reg->name }} registered for
                                <strong>{{ $reg->event->title ?? 'N/A' }}</strong>
                            </span>
                            <span class="dashboard__activity-desc">
                                ID: {{ $reg->registration_id }}
                            </span>
                            <span class="dashboard__activity-time-ago">{{ $reg->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="dashboard__empty">No recent registrations.</p>
                @endforelse
            </div>

            {{-- BAPTISMS --}}
            <div class="dashboard__activity-list" id="activity-baptisms">
                @forelse($recentBaptisms as $baptism)
                    <div class="dashboard__activity-item">
                        <div class="dashboard__activity-icon dashboard__activity-icon--baptism">
                            <i class="fas fa-water"></i>
                        </div>
                        <div class="dashboard__activity-info">
                            <span class="dashboard__activity-title">
                                Baptism request from <strong>{{ $baptism->name }}</strong>
                                <span class="dashboard__activity-badge badge badge-{{ $baptism->status }}">
                                    {{ ucfirst($baptism->status) }}
                                </span>
                            </span>
                            <span class="dashboard__activity-desc">
                                Location: {{ $baptism->location }}
                            </span>
                            <span class="dashboard__activity-time-ago">{{ $baptism->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="dashboard__empty">No recent baptism requests.</p>
                @endforelse
            </div>

            {{-- MESSAGES --}}
            <div class="dashboard__activity-list" id="activity-messages">
                @forelse($recentMessages as $message)
                    <div class="dashboard__activity-item">
                        <div class="dashboard__activity-icon dashboard__activity-icon--message">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="dashboard__activity-info">
                            <span class="dashboard__activity-title">
                                Message from <strong>{{ $message->name }}</strong>
                                <span class="dashboard__activity-badge badge badge-{{ $message->status }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </span>
                            <span class="dashboard__activity-desc">
                                Subject: {{ $message->subject }}
                            </span>
                            <span class="dashboard__activity-time-ago">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="dashboard__empty">No recent messages.</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- ─── UPCOMING EVENTS ─── --}}
    <div class="dashboard__card dashboard__card--full">
        <div class="dashboard__card-header">
            <h3><i class="fas fa-calendar-alt"></i> Upcoming Events</h3>
            <a href="{{ route('admin.events.index') }}" class="dashboard__card-link">View All</a>
        </div>
        <div class="dashboard__card-body">
            @if($upcomingEvents->count() > 0)
                <div class="dashboard__upcoming-events">
                    @foreach($upcomingEvents as $event)
                        <div class="dashboard__upcoming-event">
                            <div class="dashboard__upcoming-event-date">
                                <span class="dashboard__upcoming-event-day">{{ $event->date->format('d') }}</span>
                                <span class="dashboard__upcoming-event-month">{{ $event->date->format('M') }}</span>
                            </div>
                            <div class="dashboard__upcoming-event-info">
                                <span class="dashboard__upcoming-event-title">{{ $event->title }}</span>
                                <span class="dashboard__upcoming-event-meta">
                                    <i class="fas fa-map-marker-alt"></i> {{ $event->location }}
                                    <i class="fas fa-clock" style="margin-left: 12px;"></i> {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                </span>
                            </div>
                            <div class="dashboard__upcoming-event-registrations">
                                <i class="fas fa-users"></i>
                                {{ $event->registrations()->count() }}
                                @if($event->capacity)
                                    / {{ $event->capacity }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="dashboard__empty">No upcoming events.</p>
            @endif
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── COLORS ───
        const colors = {
            gold: '#a67c4e',
            goldLight: '#c69a6a',
            goldDim: 'rgba(166, 124, 78, 0.1)',
            green: '#28a745',
            yellow: '#e8a838',
            red: '#dc3545',
            blue: '#4A9E9E',
            purple: '#6f42c1',
        };

        // ─── LAZY LOAD CHARTS WITH INTERSECTION OBSERVER ───
        function initCharts() {
            // ─── REVENUE CHART ───
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Revenue (R)',
                            data: @json($monthlyRevenue),
                            backgroundColor: colors.goldDim,
                            borderColor: colors.gold,
                            borderWidth: 2,
                            borderRadius: 4,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'R' + context.parsed.y.toFixed(2);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'R' + value.toFixed(0);
                                    }
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            // ─── ORDERS CHART ───
            const ordersCtx = document.getElementById('ordersChart');
            if (ordersCtx) {
                new Chart(ordersCtx, {
                    type: 'line',
                    data: {
                        labels: @json($months),
                        datasets: [{
                            label: 'Orders',
                            data: @json($monthlyOrders),
                            backgroundColor: 'rgba(74, 158, 158, 0.1)',
                            borderColor: colors.blue,
                            borderWidth: 2,
                            pointBackgroundColor: colors.blue,
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            fill: true,
                            tension: 0.4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        }

        // ─── CHECK IF CHART.JS IS LOADED ───
        if (typeof Chart !== 'undefined') {
            initCharts();
        } else {
            // ─── WAIT FOR CHART.JS TO LOAD ───
            const checkChart = setInterval(function() {
                if (typeof Chart !== 'undefined') {
                    clearInterval(checkChart);
                    initCharts();
                }
            }, 100);
        }

        // ─── ACTIVITY TABS ───
        const tabs = document.querySelectorAll('.dashboard__activity-tab');
        const lists = document.querySelectorAll('.dashboard__activity-list');

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                // Remove active from all tabs
                tabs.forEach(function(t) {
                    t.classList.remove('dashboard__activity-tab--active');
                });
                this.classList.add('dashboard__activity-tab--active');

                // Hide all lists
                lists.forEach(function(list) {
                    list.classList.remove('dashboard__activity-list--active');
                });

                // Show selected list
                const target = this.dataset.tab;
                const targetList = document.getElementById('activity-' + target);
                if (targetList) {
                    targetList.classList.add('dashboard__activity-list--active');
                }
            });
        });

        // ─── CHART RESIZE HANDLER ───
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                // Charts auto-resize with responsive: true
            }, 250);
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ secure_asset('css/admin/dashboard.css') }}">
@endpush

@endsection