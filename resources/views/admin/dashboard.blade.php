@extends('admin.layouts.admin')

@section('title', 'Dashboard · ' . env('PROJECT_NAME', 'IN.iN'))
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')

<div class="dashboard">

    {{-- ─── STATS CARDS ─── --}}
    <div class="dashboard__stats-grid">
        {{-- Total Orders --}}
        <div class="dashboard__stat-card dashboard__stat-card--orders">
            <div class="dashboard__stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['total_orders'] }}</span>
                <span class="dashboard__stat-label">Total Orders</span>
            </div>
        </div>

        {{-- Total Revenue --}}
        <div class="dashboard__stat-card dashboard__stat-card--revenue">
            <div class="dashboard__stat-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">R{{ number_format($stats['total_revenue'], 0) }}</span>
                <span class="dashboard__stat-label">Total Revenue</span>
                @if($stats['revenue_change'] > 0)
                    <span class="dashboard__stat-change dashboard__stat-change--up">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['revenue_change'] }}%
                    </span>
                @elseif($stats['revenue_change'] < 0)
                    <span class="dashboard__stat-change dashboard__stat-change--down">
                        <i class="fas fa-arrow-down"></i> {{ $stats['revenue_change'] }}%
                    </span>
                @else
                    <span class="dashboard__stat-change" style="color: var(--muted); background: var(--paper);">
                        <i class="fas fa-minus"></i> 0%
                    </span>
                @endif
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="dashboard__stat-card dashboard__stat-card--pending">
            <div class="dashboard__stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['pending_orders'] }}</span>
                <span class="dashboard__stat-label">Pending Orders</span>
                <span class="dashboard__stat-sub">
                    {{ $stats['pending_percentage'] }}% of total orders
                </span>
                @if($stats['pending_change'] > 0)
                    <span class="dashboard__stat-change dashboard__stat-change--up" style="color: #e8a838; background: rgba(232, 168, 56, 0.08);">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['pending_change'] }}%
                    </span>
                @elseif($stats['pending_change'] < 0)
                    <span class="dashboard__stat-change dashboard__stat-change--down">
                        <i class="fas fa-arrow-down"></i> {{ $stats['pending_change'] }}%
                    </span>
                @else
                    <span class="dashboard__stat-change" style="color: var(--muted); background: var(--paper);">
                        <i class="fas fa-minus"></i> 0%
                    </span>
                @endif
            </div>
        </div>

        {{-- Total Registrations --}}
        <div class="dashboard__stat-card dashboard__stat-card--registrations">
            <div class="dashboard__stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="dashboard__stat-content">
                <span class="dashboard__stat-number">{{ $stats['total_registrations'] }}</span>
                <span class="dashboard__stat-label">Event Registrations</span>
                @if($stats['registrations_change'] > 0)
                    <span class="dashboard__stat-change dashboard__stat-change--up">
                        <i class="fas fa-arrow-up"></i> +{{ $stats['registrations_change'] }}%
                    </span>
                @elseif($stats['registrations_change'] < 0)
                    <span class="dashboard__stat-change dashboard__stat-change--down">
                        <i class="fas fa-arrow-down"></i> {{ $stats['registrations_change'] }}%
                    </span>
                @else
                    <span class="dashboard__stat-change" style="color: var(--muted); background: var(--paper);">
                        <i class="fas fa-minus"></i> 0%
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── CHARTS ROW ─── --}}
    <div class="dashboard__charts-row dashboard__charts-row--three">
        {{-- REVENUE CHART --}}
        <div class="dashboard__chart-card dashboard__chart-card--revenue">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-chart-line"></i> Revenue</h3>
                <div class="dashboard__chart-controls">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="dashboard__chart-form" id="chartFormRevenue">
                        <input type="hidden" name="orders_range" value="{{ $ordersRange }}">
                        <input type="hidden" name="orders_start_date" value="{{ $ordersStart ? $ordersStart->format('Y-m-d') : '' }}">
                        <input type="hidden" name="orders_end_date" value="{{ $ordersEnd ? $ordersEnd->format('Y-m-d') : '' }}">
                        
                        <select name="revenue_range" class="dashboard__chart-select" onchange="this.form.submit()">
                            <option value="daily" {{ $revenueRange === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $revenueRange === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $revenueRange === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="custom" {{ $revenueRange === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                        
                        <div class="dashboard__chart-date-range {{ $revenueRange === 'custom' ? 'dashboard__chart-date-range--visible' : '' }}">
                            <input type="date" name="revenue_start_date" value="{{ $revenueStart ? $revenueStart->format('Y-m-d') : '' }}" min="2026-01-01">
                            <span>to</span>
                            <input type="date" name="revenue_end_date" value="{{ $revenueEnd ? $revenueEnd->format('Y-m-d') : '' }}" min="2026-01-01">
                        </div>
                    </form>
                </div>
            </div>
            <div class="dashboard__chart-body">
                @if($hasRevenueData)
                    <canvas id="revenueChart"></canvas>
                @else
                    <div class="dashboard__chart-empty">
                        <i class="fas fa-chart-line"></i>
                        <p>No revenue data yet.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- EVENTS PIE CHART --}}
        <div class="dashboard__chart-card dashboard__chart-card--events">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-calendar-check"></i> Registrations</h3>
                <span class="dashboard__chart-period">{{ $upcomingEvents->count() }} Upcoming</span>
            </div>
            <div class="dashboard__chart-body dashboard__chart-body--pie">
                @if($upcomingEvents->count() > 0)
                    <div class="dashboard__event-pie-container">
                        <div class="dashboard__event-pie-wrapper">
                            <canvas id="eventsPieChart"></canvas>
                            <div class="dashboard__event-pie-legend">
                                @foreach($upcomingEvents as $item)
                                    <div class="dashboard__event-pie-legend-item">
                                        <span class="dashboard__event-pie-legend-dot" style="background: {{ ['#B8926A', '#D4AF85', '#2C6E7F', '#6f42c1', '#28a745', '#e8a838'][$loop->index % 6] }};"></span>
                                        <span class="dashboard__event-pie-legend-label">{{ Str::limit($item['event']->title, 15) }}</span>
                                        <span class="dashboard__event-pie-legend-value">{{ $item['registered'] }}/{{ $item['capacity'] ?: '∞' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="dashboard__chart-empty">
                        <i class="fas fa-calendar-alt"></i>
                        <p>No upcoming events.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ORDERS CHART --}}
        <div class="dashboard__chart-card dashboard__chart-card--orders">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-shopping-bag"></i> Orders</h3>
                <div class="dashboard__chart-controls">
                    <form method="GET" action="{{ route('admin.dashboard') }}" class="dashboard__chart-form" id="chartFormOrders">
                        <input type="hidden" name="revenue_range" value="{{ $revenueRange }}">
                        <input type="hidden" name="revenue_start_date" value="{{ $revenueStart ? $revenueStart->format('Y-m-d') : '' }}">
                        <input type="hidden" name="revenue_end_date" value="{{ $revenueEnd ? $revenueEnd->format('Y-m-d') : '' }}">
                        
                        <select name="orders_range" class="dashboard__chart-select" onchange="this.form.submit()">
                            <option value="daily" {{ $ordersRange === 'daily' ? 'selected' : '' }}>Daily</option>
                            <option value="weekly" {{ $ordersRange === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="monthly" {{ $ordersRange === 'monthly' ? 'selected' : '' }}>Monthly</option>
                            <option value="custom" {{ $ordersRange === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                        
                        <div class="dashboard__chart-date-range {{ $ordersRange === 'custom' ? 'dashboard__chart-date-range--visible' : '' }}">
                            <input type="date" name="orders_start_date" value="{{ $ordersStart ? $ordersStart->format('Y-m-d') : '' }}" min="2026-01-01">
                            <span>to</span>
                            <input type="date" name="orders_end_date" value="{{ $ordersEnd ? $ordersEnd->format('Y-m-d') : '' }}" min="2026-01-01">
                        </div>
                    </form>
                </div>
            </div>
            <div class="dashboard__chart-body">
                @if($hasOrdersData)
                    <canvas id="ordersChart"></canvas>
                @else
                    <div class="dashboard__chart-empty">
                        <i class="fas fa-shopping-bag"></i>
                        <p>No order data yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ─── THREE COLUMN ─── --}}
    <div class="dashboard__three-col">
        {{-- TOP BOOKS --}}
        <div class="dashboard__card">
            <div class="dashboard__card-header">
                <h3><i class="fas fa-crown"></i> Top Books</h3>
                <a href="{{ route('admin.books.index') }}" class="dashboard__card-link">
                    View All <i class="fas fa-arrow-right"></i>
                </a>
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
                    <p class="dashboard__empty">No books sold yet.</p>
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
                            <span class="dashboard__order-status-number">{{ $stats['paid_orders'] }} ({{ $stats['paid_percentage'] }}%)</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--paid" style="width: {{ $stats['paid_percentage'] }}%;"></div>
                        </div>
                    </div>

                    <div class="dashboard__order-status-item">
                        <div class="dashboard__order-status-info">
                            <span class="dashboard__order-status-label">
                                <span class="dashboard__order-status-dot dashboard__order-status-dot--pending"></span>
                                Pending
                            </span>
                            <span class="dashboard__order-status-number">{{ $stats['pending_orders'] }} ({{ $stats['pending_percentage'] }}%)</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--pending" style="width: {{ $stats['pending_percentage'] }}%;"></div>
                        </div>
                    </div>

                    <div class="dashboard__order-status-item">
                        <div class="dashboard__order-status-info">
                            <span class="dashboard__order-status-label">
                                <span class="dashboard__order-status-dot dashboard__order-status-dot--failed"></span>
                                Failed
                            </span>
                            <span class="dashboard__order-status-number">{{ $stats['failed_orders'] }} ({{ $stats['failed_percentage'] }}%)</span>
                        </div>
                        <div class="dashboard__order-status-bar">
                            <div class="dashboard__order-status-bar-fill dashboard__order-status-bar-fill--failed" style="width: {{ $stats['failed_percentage'] }}%;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RECENT ACTIVITY --}}
        <div class="dashboard__card">
            <div class="dashboard__card-header">
                <h3><i class="fas fa-bolt"></i> Recent Activity</h3>
                <span class="dashboard__card-badge">Latest 3</span>
            </div>
            <div class="dashboard__card-body dashboard__card-body--activity">
                <div class="dashboard__activity-tabs-compact">
                    <button class="dashboard__activity-tab-compact dashboard__activity-tab-compact--active" data-tab="orders-compact">
                        <i class="fas fa-shopping-cart"></i> Orders
                    </button>
                    <button class="dashboard__activity-tab-compact" data-tab="registrations-compact">
                        <i class="fas fa-users"></i> Registrations
                    </button>
                    <button class="dashboard__activity-tab-compact" data-tab="baptisms-compact">
                        <i class="fas fa-water"></i> Baptisms
                    </button>
                    <button class="dashboard__activity-tab-compact" data-tab="messages-compact">
                        <i class="fas fa-envelope"></i> Messages
                    </button>
                </div>

                <div class="dashboard__activity-list-compact">
                    {{-- ORDERS --}}
                    <div class="dashboard__activity-list-compact-inner dashboard__activity-list-compact-inner--active" id="activity-orders-compact">
                        @forelse($recentOrders as $order)
                            <div class="dashboard__activity-item-compact">
                                <a href="{{ route('admin.orders.show', $order) }}" class="dashboard__activity-link-compact">
                                    {{ $order->order_number }}
                                </a>
                                <span class="dashboard__activity-desc-compact">
                                    {{ $order->buyer_name }}
                                </span>
                                <span class="dashboard__activity-badge badge badge-{{ $order->payment_status }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        @empty
                            <p class="dashboard__empty">No recent orders.</p>
                        @endforelse
                    </div>

                    {{-- REGISTRATIONS --}}
                    <div class="dashboard__activity-list-compact-inner" id="activity-registrations-compact">
                        @forelse($recentRegistrations as $reg)
                            <div class="dashboard__activity-item-compact">
                                <a href="{{ route('admin.events.registrations', $reg->event_id) }}" class="dashboard__activity-link-compact">
                                    {{ $reg->name }}
                                </a>
                                <span class="dashboard__activity-desc-compact">
                                    {{ $reg->event->title ?? 'N/A' }}
                                </span>
                                <span class="dashboard__activity-badge badge badge-free">New</span>
                            </div>
                        @empty
                            <p class="dashboard__empty">No recent registrations.</p>
                        @endforelse
                    </div>

                    {{-- BAPTISMS --}}
                    <div class="dashboard__activity-list-compact-inner" id="activity-baptisms-compact">
                        @forelse($recentBaptisms as $baptism)
                            <div class="dashboard__activity-item-compact">
                                <a href="{{ route('admin.baptisms') }}" class="dashboard__activity-link-compact">
                                    {{ $baptism->name }}
                                </a>
                                <span class="dashboard__activity-desc-compact">
                                    {{ $baptism->location }}
                                </span>
                                <span class="dashboard__activity-badge badge badge-{{ $baptism->status }}">
                                    {{ ucfirst($baptism->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="dashboard__empty">No recent baptisms.</p>
                        @endforelse
                    </div>

                    {{-- MESSAGES --}}
                    <div class="dashboard__activity-list-compact-inner" id="activity-messages-compact">
                        @forelse($recentMessages as $message)
                            <div class="dashboard__activity-item-compact">
                                <a href="{{ route('admin.messages.show', $message) }}" class="dashboard__activity-link-compact">
                                    {{ $message->name }}
                                </a>
                                <span class="dashboard__activity-desc-compact">
                                    {{ $message->subject }}
                                </span>
                                <span class="dashboard__activity-badge badge badge-{{ $message->status }}">
                                    {{ ucfirst($message->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="dashboard__empty">No recent messages.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── COLORS ───
        const colors = {
            gold: '#B8926A',
            goldLight: '#D4AF85',
            green: '#28a745',
            yellow: '#e8a838',
            red: '#dc3545',
            teal: '#2C6E7F',
            purple: '#6f42c1',
        };

        // ─── INIT CHARTS ───
        function initCharts() {
            const hasRevenueData = @json($hasRevenueData);
            const hasOrdersData = @json($hasOrdersData);
            const eventsData = @json($upcomingEvents);
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const textColor = isDark ? '#9A9AAE' : '#6A6A7A';
            const gridColor = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(10, 31, 51, 0.06)';
            
            // ─── REVENUE CHART (Bar) ───
            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx && hasRevenueData) {
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: @json($revenueLabels),
                        datasets: [{
                            label: 'Revenue (R)',
                            data: @json($revenueData),
                            backgroundColor: 'rgba(184, 146, 106, 0.5)',
                            borderColor: '#B8926A',
                            borderWidth: 1.5,
                            borderRadius: 6,
                            maxBarThickness: 32,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#1A2430' : '#0A1F33',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
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
                                    callback: function(value) { return 'R' + value.toFixed(0); },
                                    maxTicksLimit: 6,
                                    color: textColor,
                                    font: { size: 10, family: 'Montserrat' }
                                },
                                grid: { color: gridColor }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    maxTicksLimit: 10,
                                    autoSkip: true,
                                    color: textColor,
                                    font: { size: 10, family: 'Montserrat' }
                                }
                            }
                        }
                    }
                });
            }

            // ─── ORDERS CHART (Line) ───
            const ordersCtx = document.getElementById('ordersChart');
            if (ordersCtx && hasOrdersData) {
                new Chart(ordersCtx, {
                    type: 'line',
                    data: {
                        labels: @json($ordersLabels),
                        datasets: [{
                            label: 'Orders',
                            data: @json($ordersData),
                            backgroundColor: 'rgba(44, 110, 127, 0.12)',
                            borderColor: '#2C6E7F',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#2C6E7F',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            fill: true,
                            tension: 0.35,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#1A2430' : '#0A1F33',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y + ' order(s)';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { 
                                    stepSize: 1,
                                    maxTicksLimit: 6,
                                    color: textColor,
                                    font: { size: 10, family: 'Montserrat' }
                                },
                                grid: { color: gridColor }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    maxTicksLimit: 10,
                                    autoSkip: true,
                                    color: textColor,
                                    font: { size: 10, family: 'Montserrat' }
                                }
                            }
                        }
                    }
                });
            }

            // ─── EVENTS PIE CHART ───
            const pieCtx = document.getElementById('eventsPieChart');
            if (pieCtx && eventsData.length > 0) {
                const labels = eventsData.map(function(item) {
                    return item.event.title.length > 15 ? item.event.title.substring(0, 15) + '...' : item.event.title;
                });
                const rates = eventsData.map(function(item) {
                    return item.capacity > 0 ? Math.min((item.registered / item.capacity) * 100, 100) : 0;
                });
                const pieColors = ['#B8926A', '#D4AF85', '#2C6E7F', '#6f42c1', '#28a745', '#e8a838'];

                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: rates,
                            backgroundColor: pieColors.slice(0, eventsData.length),
                            borderWidth: 2,
                            borderColor: isDark ? '#1A2430' : '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: isDark ? '#1A2430' : '#0A1F33',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        const data = eventsData[context.dataIndex];
                                        return data.event.title + ': ' + data.registered + '/' + (data.capacity || '∞') + ' registered';
                                    }
                                }
                            }
                        },
                    }
                });
            }
        }

        // ─── WAIT FOR CHART.JS ───
        if (typeof Chart !== 'undefined') {
            initCharts();
        } else {
            const checkChart = setInterval(function() {
                if (typeof Chart !== 'undefined') {
                    clearInterval(checkChart);
                    initCharts();
                }
            }, 100);
        }

        // ─── COMPACT ACTIVITY TABS ───
        const compactTabs = document.querySelectorAll('.dashboard__activity-tab-compact');
        const compactLists = document.querySelectorAll('.dashboard__activity-list-compact-inner');

        compactTabs.forEach(function(tab) {
            tab.addEventListener('click', function() {
                compactTabs.forEach(function(t) { t.classList.remove('dashboard__activity-tab-compact--active'); });
                this.classList.add('dashboard__activity-tab-compact--active');

                compactLists.forEach(function(list) { list.classList.remove('dashboard__activity-list-compact-inner--active'); });

                const target = this.dataset.tab;
                const targetList = document.getElementById('activity-' + target);
                if (targetList) {
                    targetList.classList.add('dashboard__activity-list-compact-inner--active');
                }
            });
        });

        // ─── DATE RANGE TOGGLE ───
        document.querySelectorAll('.dashboard__chart-select').forEach(function(select) {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });

        document.querySelectorAll('.dashboard__chart-date-range input[type="date"]').forEach(function(input) {
            input.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ secure_asset('css/admin/v150/dashboard.css') }}">
@endpush

@endsection