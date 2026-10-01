@extends('admin.layouts.admin')

@section('title', 'Order ' . $order->order_number . ' · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Order Details')
@section('breadcrumb', 'Orders / View')

@section('content')

<div class="orders-detail">
    {{-- ─── HEADER ─── --}}
    <div class="orders-detail__header">
        <a href="{{ route('admin.orders.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        <div>
            <span class="badge badge-{{ $order->payment_status }}" style="font-size: 0.9rem; padding: 8px 18px;">
                <i class="fas {{ $order->payment_status === 'paid' ? 'fa-check-circle' : ($order->payment_status === 'pending' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    {{-- ─── ORDER CARD ─── --}}
    <div class="orders-detail__card">
        <div class="orders-detail__card-header">
            <div>
                <h3>Order #{{ $order->order_number }}</h3>
                <span class="orders-detail__created-at">
                    <i class="fas fa-calendar-alt"></i>
                    {{ $order->created_at->format('F d, Y g:i A') }}
                </span>
            </div>
            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="status-update-form">
                @csrf
                @method('PUT')
                <select name="payment_status" class="orders-detail__status-select" onchange="this.form.submit()">
                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </form>
        </div>

        <div class="orders-detail__body">
            {{-- ─── BUYER DETAILS ─── --}}
            <div class="orders-detail__info">
                <h4><i class="fas fa-user"></i> Buyer Details</h4>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Name</span>
                    <span class="orders-detail__info-value">{{ $order->buyer_name }}</span>
                </div>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Email</span>
                    <span class="orders-detail__info-value">
                        <a href="mailto:{{ $order->buyer_email }}">
                            {{ $order->buyer_email }}
                        </a>
                    </span>
                </div>
                @if($order->buyer_phone)
                    <div class="orders-detail__info-row">
                        <span class="orders-detail__info-label">Phone</span>
                        <span class="orders-detail__info-value">
                            <a href="tel:{{ $order->buyer_phone }}" style="color: var(--muted);">
                                {{ $order->buyer_phone }}
                            </a>
                        </span>
                    </div>
                @endif

                @if($order->isHardcopy())
                    <div class="order-show__section order-show__section--delivery">
                        <h3 class="order-show__section-title">
                            <i class="fas fa-truck"></i> Delivery
                        </h3>

                        <div class="order-show__delivery-badge">
                            <i class="fas fa-box"></i>
                            <span>{{ $order->shipping_region_label }}</span>
                            <span class="order-show__delivery-badge-fee">R{{ number_format((float) $order->shipping_fee, 2) }}</span>
                        </div>

                        <div class="order-show__delivery-address">
                            <strong>{{ $order->delivery_name }}</strong>
                            @if($order->delivery_phone)
                                <span>{{ $order->delivery_phone }}</span>
                            @endif
                            <span>{{ $order->delivery_address_1 }}</span>
                            @if($order->delivery_address_2)<span>{{ $order->delivery_address_2 }}</span>@endif
                            @if($order->delivery_suburb)<span>{{ $order->delivery_suburb }}</span>@endif
                            <span>{{ $order->delivery_city }}, {{ $order->delivery_province }} {{ $order->delivery_postal_code }}</span>
                            <span>{{ $order->delivery_country }}</span>
                        </div>

                        @if($order->delivery_notes)
                            <div class="order-show__delivery-notes">
                                <i class="fas fa-sticky-note"></i>
                                {{ $order->delivery_notes }}
                            </div>
                        @endif

                        <div class="order-show__fulfillment">
                            <span class="order-show__fulfillment-label">Fulfillment status:</span>
                            <span class="order-show__fulfillment-value">{{ str_replace('_', ' ', ucfirst($order->fulfillment_status)) }}</span>
                        </div>

                        @if($order->tracking_number)
                            <div class="order-show__tracking">
                                <span class="order-show__tracking-label">Tracking:</span>
                                <span class="order-show__tracking-value">{{ $order->tracking_number }}</span>
                            </div>
                        @endif

                        {{-- ─── MARK AS SHIPPED ─── --}}
                        @if($order->payment_status === 'paid' && in_array($order->fulfillment_status, ['awaiting_shipment', 'awaiting_address']))
                            <form method="POST" action="{{ route('admin.orders.mark-shipped', $order) }}" class="order-show__ship-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="tracking_number">Tracking Number (optional)</label>
                                    <input type="text" name="tracking_number" id="tracking_number" placeholder="e.g. SAPO tracking number">
                                </div>

                                <button type="submit" class="btn btn--primary">
                                    <i class="fas fa-shipping-fast"></i> Mark as Shipped
                                </button>
                            </form>
                        @endif

                        @if($order->fulfillment_status === 'shipped' && !$order->delivered_at)
                            <form method="POST" action="{{ route('admin.orders.mark-delivered', $order) }}" class="order-show__ship-form">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn--success">
                                    <i class="fas fa-check"></i> Mark as Delivered
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            {{-- ─── BOOK DETAILS ─── --}}
            <div class="orders-detail__book">
                <h4><i class="fas fa-book"></i> Book Details</h4>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Title</span>
                    <span class="orders-detail__info-value">
                        <strong>{{ $order->book->title ?? 'N/A' }}</strong>
                    </span>
                </div>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Price</span>
                    <span class="orders-detail__info-value orders-detail__info-value--gold">
                        R{{ number_format($order->amount, 2) }}
                    </span>
                </div>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Payment Method</span>
                    <span class="orders-detail__info-value">
                        {{ ucfirst($order->payment_method ?? 'N/A') }}
                    </span>
                </div>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Transaction ID</span>
                    <span class="orders-detail__info-value orders-detail__info-value--mono">
                        {{ $order->transaction_id ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── DOWNLOAD TOKEN ─── --}}
        <div class="orders-detail__download">
            <h4><i class="fas fa-link"></i> Download Token</h4>
            <div class="orders-detail__token">
                <code>{{ $order->download_token }}</code>
                <button class="btn btn--secondary btn--sm" onclick="copyToClipboard('{{ $order->download_token }}')" title="Copy token">
                    <i class="fas fa-copy"></i> Copy
                </button>
                <a href="{{ route('payment.download', $order->download_token) }}" target="_blank" class="btn btn--primary btn--sm" title="Test download">
                    <i class="fas fa-download"></i> Test
                </a>
            </div>
            <span class="orders-detail__download-meta">
                <i class="fas fa-info-circle"></i>
                Downloads: {{ $order->download_count }}
                @if($order->expires_at)
                    · Expires: {{ $order->expires_at->format('M d, Y g:i A') }}
                @else
                    · No expiry set
                @endif
            </span>
        </div>

        {{-- ─── ACTIONS ─── --}}
        <div class="orders-detail__actions">
            <a href="mailto:{{ $order->buyer_email }}" class="btn btn--primary">
                <i class="fas fa-envelope"></i> Email Buyer
            </a>
            <a href="{{ route('payment.download', $order->download_token) }}" target="_blank" class="btn btn--success" style="background: #28A745; color: #fff;">
                <i class="fas fa-download"></i> Download Book
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/orders.css') }}">
@endpush

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            showFlashMessage('Token copied to clipboard!', 'success');
        }).catch(function() {
            const input = document.createElement('input');
            input.value = text;
            document.body.appendChild(input);
            input.select();
            document.execCommand('copy');
            document.body.removeChild(input);
            showFlashMessage('Token copied to clipboard!', 'success');
        });
    }
</script>
@endpush