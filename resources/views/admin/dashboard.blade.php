@extends('admin.layouts.admin')

@section('title', 'Dashboard · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Overview')

@section('content')

<div class="dashboard">

    {{-- ─── STATS CARDS ─── --}}
    <div class="dashboard__stats-grid">
        {{-- Total Orders (NO percentage stat) --}}
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
                    <span class="dashboard__stat-change" style="color: var(--text-muted); background: var(--bg);">
                        <i class="fas fa-minus"></i> 0%
                    </span>
                @endif
            </div>
        </div>

        {{-- Pending Orders (Percentage of Total) --}}
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
                    <span class="dashboard__stat-change" style="color: var(--text-muted); background: var(--bg);">
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
                    <span class="dashboard__stat-change" style="color: var(--text-muted); background: var(--bg);">
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
                        
                        <div class="dashboard__chart-date-range" style="display: {{ $revenueRange === 'custom' ? 'flex' : 'none' }};">
                            <input type="date" name="revenue_start_date" value="{{ $revenueStart ? $revenueStart->format('Y-m-d') : '' }}" min="2026-01-01" onchange="this.form.submit()">
                            <span>to</span>
                            <input type="date" name="revenue_end_date" value="{{ $revenueEnd ? $revenueEnd->format('Y-m-d') : '' }}" min="2026-01-01" onchange="this.form.submit()">
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
                        <p>No revenue data.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- EVENTS PIE CHART --}}
        <div class="dashboard__chart-card dashboard__chart-card--events">
            <div class="dashboard__chart-header">
                <h3><i class="fas fa-calendar-check"></i> Event Registrations</h3>
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
                                        <span class="dashboard__event-pie-legend-dot" style="background: {{ ['#a67c4e', '#c69a6a', '#4A9E9E', '#6f42c1', '#28a745', '#e8a838'][$loop->index % 6] }};"></span>
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

        {{-- ORDERS CHART (Line Graph) --}}
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
                        
                        <div class="dashboard__chart-date-range" style="display: {{ $ordersRange === 'custom' ? 'flex' : 'none' }};">
                            <input type="date" name="orders_start_date" value="{{ $ordersStart ? $ordersStart->format('Y-m-d') : '' }}" min="2026-01-01" onchange="this.form.submit()">
                            <span>to</span>
                            <input type="date" name="orders_end_date" value="{{ $ordersEnd ? $ordersEnd->format('Y-m-d') : '' }}" min="2026-01-01" onchange="this.form.submit()">
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
                        <p>No order data.</p>
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
            gold: '#a67c4e',
            goldLight: '#c69a6a',
            goldDim: 'rgba(166, 124, 78, 0.1)',
            green: '#28a745',
            yellow: '#e8a838',
            red: '#dc3545',
            blue: '#4A9E9E',
            purple: '#6f42c1',
        };

        // ─── INIT CHARTS ───
        function initCharts() {
            const hasRevenueData = @json($hasRevenueData);
            const hasOrdersData = @json($hasOrdersData);
            const eventsData = @json($upcomingEvents);
            
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
                            backgroundColor: 'rgba(166, 124, 78, 0.5)',
                            borderColor: '#a67c4e',
                            borderWidth: 1.5,
                            borderRadius: 3,
                            maxBarThickness: 30,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
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
                                    callback: function(value) { return 'R' + value.toFixed(0); },
                                    maxTicksLimit: 6,
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    maxTicksLimit: 10,
                                    autoSkip: true,
                                    font: { size: 8 }
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
                            backgroundColor: 'rgba(74, 158, 158, 0.15)',
                            borderColor: '#4A9E9E',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#4A9E9E',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 3.5,
                            pointHoverRadius: 5.5,
                            fill: true,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
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
                                }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { 
                                    maxTicksLimit: 10,
                                    autoSkip: true,
                                    font: { size: 8 }
                                }
                            }
                        }
                    }
                });
            }

            // ─── EVENTS PIE CHART (Regular Pie, not Doughnut) ───
            const pieCtx = document.getElementById('eventsPieChart');
            if (pieCtx && eventsData.length > 0) {
                const labels = eventsData.map(function(item) {
                    return item.event.title.length > 15 ? item.event.title.substring(0, 15) + '...' : item.event.title;
                });
                const rates = eventsData.map(function(item) {
                    return item.capacity > 0 ? Math.min((item.registered / item.capacity) * 100, 100) : 0;
                });
                const pieColors = ['#a67c4e', '#c69a6a', '#4A9E9E', '#6f42c1', '#28a745', '#e8a838'];

                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: rates,
                            backgroundColor: pieColors.slice(0, eventsData.length),
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
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
<link rel="stylesheet" href="{{ secure_asset('css/admin/dashboard.css') }}">
<style>
    /* ─── STAT CARDS COLORS ─── */
    .dashboard__stat-card--orders .dashboard__stat-icon {
        background: rgba(166, 124, 78, 0.12);
        color: #a67c4e;
    }
    .dashboard__stat-card--revenue .dashboard__stat-icon {
        background: rgba(40, 167, 69, 0.12);
        color: #28a745;
    }
    .dashboard__stat-card--pending .dashboard__stat-icon {
        background: rgba(232, 168, 56, 0.12);
        color: #e8a838;
    }
    .dashboard__stat-card--registrations .dashboard__stat-icon {
        background: rgba(74, 158, 158, 0.12);
        color: #4A9E9E;
    }

    .dashboard__stat-sub {
        font-size: 0.65rem;
        color: var(--text-muted);
        display: block;
        margin-top: 2px;
    }

    .dashboard__stat-change {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.65rem;
        font-weight: 600;
        margin-top: 2px;
        padding: 1px 8px;
        border-radius: 50px;
    }

    .dashboard__stat-change--up {
        color: #28a745;
        background: rgba(40, 167, 69, 0.08);
    }

    .dashboard__stat-change--down {
        color: #dc3545;
        background: rgba(220, 53, 69, 0.08);
    }

    /* ─── THREE COLUMN ─── */
    .dashboard__three-col {
        display: grid;
        /* grid-template-columns: 1fr 1fr 1fr; */
        gap: 16px;
        margin-bottom: 24px;
    }

    /* ─── CHARTS ROW (3 Columns) ─── */
    .dashboard__charts-row--three {
        display: grid;
        grid-template-columns: 1fr 0.7fr 1fr;
        gap: 16px;
        margin-bottom: 24px;
    }

    /* ─── CHART BODY ─── */
    .dashboard__chart-body {
        padding: 8px 12px 12px;
        height: 200px;
        position: relative;
    }

    .dashboard__chart-body canvas {
        width: 100% !important;
        height: 100% !important;
    }

    /* ─── EVENT PIE CHART ─── */
    .dashboard__event-pie-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 180px;
        padding: 4px 0;
    }

    .dashboard__event-pie-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        width: 100%;
    }

    .dashboard__event-pie-wrapper canvas {
        max-height: 130px !important;
        max-width: 130px !important;
        min-height: 100px;
        min-width: 100px;
    }

    .dashboard__event-pie-legend {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 6px 14px;
        width: 100%;
        padding: 0 4px;
    }

    .dashboard__event-pie-legend-item {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.6rem;
        white-space: nowrap;
    }

    .dashboard__event-pie-legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dashboard__event-pie-legend-label {
        color: var(--text);
        max-width: 70px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .dashboard__event-pie-legend-value {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.55rem;
    }

    /* ─── COMPACT ACTIVITY ─── */
    .dashboard__card-body--activity {
        padding: 8px 12px 12px;
    }

    .dashboard__activity-tabs-compact {
        display: flex;
        gap: 2px;
        margin-bottom: 6px;
        border-bottom: 1px solid var(--border);
        padding-bottom: 4px;
    }

    .dashboard__activity-tab-compact {
        padding: 2px 8px;
        border: none;
        background: transparent;
        color: var(--text-muted);
        font-size: 0.6rem;
        font-weight: 500;
        cursor: pointer;
        border-radius: var(--radius-sm);
        transition: all 0.3s ease;
    }

    .dashboard__activity-tab-compact:hover {
        color: var(--text);
        background: var(--gold-dim);
    }

    .dashboard__activity-tab-compact--active {
        color: var(--gold);
        background: rgba(166, 124, 78, 0.08);
    }

    .dashboard__activity-tab-compact i {
        margin-right: 2px;
        font-size: 0.55rem;
    }

    .dashboard__activity-list-compact-inner {
        display: none;
    }

    .dashboard__activity-list-compact-inner--active {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .dashboard__activity-item-compact {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 2px 0;
        border-bottom: 1px solid var(--border);
        font-size: 0.65rem;
    }

    .dashboard__activity-item-compact:last-child {
        border-bottom: none;
    }

    .dashboard__activity-link-compact {
        color: var(--text);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
        min-width: 40px;
        font-size: 0.6rem;
    }

    .dashboard__activity-link-compact:hover {
        color: var(--gold);
        text-decoration: underline;
    }

    .dashboard__activity-desc-compact {
        color: var(--text-muted);
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: 0.6rem;
    }

    .dashboard__activity-item-compact .badge {
        font-size: 0.4rem;
        padding: 1px 4px;
        flex-shrink: 0;
    }

    /* ─── CHART CONTROLS ─── */
    .dashboard__chart-controls {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dashboard__chart-form {
        display: flex;
        align-items: center;
        gap: 4px;
        flex-wrap: wrap;
    }

    .dashboard__chart-select {
        padding: 1px 6px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.55rem;
        background: var(--surface);
        color: var(--text);
        cursor: pointer;
        transition: border-color 0.3s ease;
        height: 22px;
    }

    .dashboard__chart-select:focus {
        outline: none;
        border-color: var(--gold);
    }

    .dashboard__chart-date-range {
        display: none;
        align-items: center;
        gap: 3px;
    }

    .dashboard__chart-date-range input[type="date"] {
        padding: 1px 4px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-family: var(--font);
        font-size: 0.55rem;
        background: var(--surface);
        color: var(--text);
        cursor: pointer;
        height: 22px;
        width: 90px;
    }

    .dashboard__chart-date-range input[type="date"]:focus {
        outline: none;
        border-color: var(--gold);
    }

    .dashboard__chart-date-range span {
        font-size: 0.55rem;
        color: var(--text-muted);
    }

    .dashboard__chart-period {
        font-size: 0.55rem;
        color: var(--text-muted);
        background: var(--bg);
        padding: 1px 6px;
        border-radius: 50px;
        white-space: nowrap;
        height: 22px;
        display: flex;
        align-items: center;
    }

    /* ─── CHART EMPTY STATE ─── */
    .dashboard__chart-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        min-height: 140px;
        color: var(--text-muted);
        text-align: center;
        padding: 12px;
    }

    .dashboard__chart-empty i {
        font-size: 1.4rem;
        color: var(--text-muted);
        opacity: 0.3;
        margin-bottom: 4px;
    }

    .dashboard__chart-empty p {
        color: var(--text-muted);
        margin: 0;
        font-size: 0.7rem;
    }

    .dashboard__chart-body--pie {
        padding: 4px 8px 8px;
        height: auto;
        min-height: 190px;
    }

    /* ─── CARD HEADER ─── */
    .dashboard__card-header {
        padding: 10px 14px;
    }

    .dashboard__card-header h3 {
        font-size: 0.8rem;
    }

    .dashboard__card-body {
        padding: 12px 14px 14px;
    }

    .dashboard__card-badge {
        font-size: 0.55rem;
        padding: 2px 8px;
    }

    /* ─── TOP BOOKS ─── */
    .dashboard__top-book {
        padding: 4px 0;
        gap: 8px;
    }

    .dashboard__top-book-rank {
        width: 20px;
        height: 20px;
        font-size: 0.6rem;
    }

    .dashboard__top-book-title {
        font-size: 0.7rem;
    }

    .dashboard__top-book-meta {
        font-size: 0.6rem;
    }

    .dashboard__top-book-bar {
        width: 60px;
        height: 3px;
    }

    .dashboard__order-status-item {
        margin-bottom: 4px;
    }

    .dashboard__order-status-info {
        margin-bottom: 2px;
    }

    .dashboard__order-status-label {
        font-size: 0.7rem;
    }

    .dashboard__order-status-number {
        font-size: 0.75rem;
    }

    .dashboard__order-status-bar {
        height: 4px;
    }

    /* ─── RESPONSIVE ─── */
    @media (max-width: 1200px) {
        .dashboard__charts-row--three {
            grid-template-columns: 1fr 0.9fr;
        }
        .dashboard__three-col {
            grid-template-columns: 1fr 1fr;
        }
        .dashboard__chart-card--events {
            grid-column: span 2;
        }
    }

    @media (max-width: 1024px) {
        .dashboard__charts-row--three {
            grid-template-columns: 1fr 0.8fr;
        }
        .dashboard__chart-body {
            height: 170px;
        }
        .dashboard__event-pie-wrapper canvas {
            max-height: 110px !important;
            max-width: 110px !important;
        }
    }

    @media (max-width: 820px) {
        .dashboard__three-col {
            grid-template-columns: 1fr;
        }
        .dashboard__charts-row--three {
            grid-template-columns: 1fr;
        }
        .dashboard__chart-card--events {
            grid-column: span 1;
        }
        .dashboard__event-pie-wrapper canvas {
            max-height: 130px !important;
            max-width: 130px !important;
        }
        .dashboard__event-pie-legend {
            gap: 4px 10px;
        }
        .dashboard__chart-body {
            height: 160px;
        }
    }

    @media (max-width: 540px) {
        .dashboard__stats-grid {
            grid-template-columns: 1fr 1fr;
        }
        .dashboard__activity-tabs-compact {
            flex-wrap: wrap;
        }
        .dashboard__activity-item-compact {
            flex-wrap: wrap;
            gap: 2px;
        }
        .dashboard__activity-desc-compact {
            white-space: normal;
            flex-basis: 100%;
        }
        .dashboard__chart-select {
            width: 100%;
        }
        .dashboard__chart-controls {
            flex-wrap: wrap;
            width: 100%;
        }
        .dashboard__chart-date-range {
            flex-wrap: wrap;
            width: 100%;
        }
        .dashboard__chart-date-range input[type="date"] {
            width: 100%;
            flex: 1;
        }
        .dashboard__chart-date-range span {
            display: none;
        }
        .dashboard__chart-body {
            height: 130px;
            padding: 4px 6px 8px;
        }
        .dashboard__event-pie-wrapper canvas {
            max-height: 100px !important;
            max-width: 100px !important;
        }
        .dashboard__event-pie-legend-item {
            font-size: 0.5rem;
        }
        .dashboard__event-pie-legend-label {
            max-width: 50px;
        }
    }

    @media (max-width: 400px) {
        .dashboard__stats-grid {
            grid-template-columns: 1fr;
        }
        .dashboard__chart-body {
            height: 110px;
        }
        .dashboard__chart-header {
            flex-wrap: wrap;
            gap: 4px;
        }
        .dashboard__chart-header h3 {
            font-size: 0.7rem;
        }
        .dashboard__event-pie-wrapper canvas {
            max-height: 80px !important;
            max-width: 80px !important;
        }
        .dashboard__event-pie-legend {
            gap: 2px 6px;
        }
        .dashboard__event-pie-legend-item {
            font-size: 0.45rem;
        }
        .dashboard__event-pie-legend-label {
            max-width: 40px;
        }
    }
</style>
@endpush

@endsection