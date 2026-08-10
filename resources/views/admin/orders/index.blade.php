@extends('admin.layouts.admin')

@section('title', 'Orders · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Orders')
@section('breadcrumb', 'Manage Orders')

@section('content')

<div class="orders-index">
    {{-- ─── HEADER ACTIONS ─── --}}
    <div class="orders-index__header">
        <div class="orders-index__search">
            <div class="orders-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text" 
                    id="ordersSearchInput" 
                    placeholder="Search by order number, name or email..." 
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="ordersSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="ordersSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
            <span class="orders-index__search-hint">
                <i class="fas fa-keyboard"></i> Type to search · <kbd>Ctrl</kbd>+<kbd>/</kbd> to focus · <kbd>Esc</kbd> to clear
            </span>
        </div>
        <div class="orders-index__actions">
            <a href="{{ route('admin.export.orders') }}" class="btn btn--success">
                <i class="fas fa-download"></i> Export CSV
            </a>
        </div>
    </div>

    {{-- ─── STATS ─── --}}
    <div class="orders-index__stats">
        <div class="orders-index__stat">
            <span class="orders-index__stat-number">{{ $totalOrders }}</span>
            <span class="orders-index__stat-label">Total Orders</span>
        </div>
        <div class="orders-index__stat">
            <span class="orders-index__stat-number">R{{ number_format($totalRevenue, 2) }}</span>
            <span class="orders-index__stat-label">Total Revenue</span>
        </div>
        <div class="orders-index__stat orders-index__stat--pending">
            <span class="orders-index__stat-number">{{ $pendingCount }}</span>
            <span class="orders-index__stat-label">Pending</span>
        </div>
        <div class="orders-index__stat orders-index__stat--paid">
            <span class="orders-index__stat-number">{{ $paidCount }}</span>
            <span class="orders-index__stat-label">Paid</span>
        </div>
        <div class="orders-index__stat orders-index__stat--failed">
            <span class="orders-index__stat-number">{{ $failedCount }}</span>
            <span class="orders-index__stat-label">Failed</span>
        </div>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="orders-index__filters">
        <a href="{{ route('admin.orders.index') }}" 
           class="orders-index__filter {{ !request('status') ? 'orders-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" 
           class="orders-index__filter {{ request('status') === 'pending' ? 'orders-index__filter--active' : '' }}">
            Pending
            @if($pendingCount > 0)
                <span class="orders-index__badge">{{ $pendingCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" 
           class="orders-index__filter {{ request('status') === 'paid' ? 'orders-index__filter--active' : '' }}">
            Paid
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'failed']) }}" 
           class="orders-index__filter {{ request('status') === 'failed' ? 'orders-index__filter--active' : '' }}">
            Failed
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'refunded']) }}" 
           class="orders-index__filter {{ request('status') === 'refunded' ? 'orders-index__filter--active' : '' }}">
            Refunded
        </a>
        
        @if(request('status') || request('search'))
            <a href="{{ route('admin.orders.index') }}" class="orders-index__filter orders-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
        
        <span class="orders-index__filter-count">{{ $orders->total() }} orders</span>
    </div>

    {{-- ─── ORDERS TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Order Number</th>
                    <th>Book</th>
                    <th>Buyer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody id="ordersSearchResults">
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span style="font-family: monospace; font-weight: 600; font-size: 0.85rem;">
                                {{ $order->order_number }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $order->book->title ?? 'N/A' }}</strong>
                        </td>
                        <td>
                            <div class="orders-index__buyer">
                                <strong>{{ $order->buyer_name }}</strong>
                                <a href="mailto:{{ $order->buyer_email }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.8rem; display: block;">
                                    {{ $order->buyer_email }}
                                </a>
                                @if($order->buyer_phone)
                                    <a href="tel:{{ $order->buyer_phone }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.75rem;">
                                        <i class="fas fa-phone"></i> {{ $order->buyer_phone }}
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: var(--gold);">
                                R{{ number_format($order->amount, 2) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->payment_status }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <span style="font-size: 0.8rem; color: var(--text-muted);">
                                {{ $order->created_at->format('M d, Y g:i A') }}
                            </span>
                        </td>
                        <td>
                            <div class="orders-index__actions">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn--primary btn--sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-shopping-cart" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No orders found.
                            @if(request('search') || request('status'))
                                <br>
                                <a href="{{ route('admin.orders.index') }}" class="btn btn--primary btn--sm" style="margin-top: 12px;">Clear filters</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($orders->hasPages())
        <div class="pagination-container">
            {{ $orders->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/orders.css') }}">
@endpush