@extends('admin.layouts.admin')

@section('title', 'Order ' . $order->order_number . ' · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Order Details')
@section('breadcrumb', 'Orders / View')

@section('content')

<div class="orders-detail">
    {{-- ─── BACK BUTTON ─── --}}
    <div class="orders-detail__header">
        <a href="{{ route('admin.orders.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
        <div class="orders-detail__status">
            <span class="badge badge-{{ $order->payment_status }}" style="font-size: 0.9rem; padding: 6px 16px;">
                <i class="fas {{ $order->payment_status === 'paid' ? 'fa-check-circle' : ($order->payment_status === 'pending' ? 'fa-clock' : 'fa-times-circle') }}"></i>
                {{ ucfirst($order->payment_status) }}
            </span>
        </div>
    </div>

    {{-- ─── ORDER CARD ─── --}}
    <div class="orders-detail__card">
        <div class="orders-detail__card-header">
            <div>
                <h3 style="font-family: var(--font-serif); font-weight: 700; font-size: 1.2rem;">
                    Order #{{ $order->order_number }}
                </h3>
                <span style="font-size: 0.8rem; color: var(--text-muted);">
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
            {{-- ─── LEFT: Order Info ─── --}}
            <div class="orders-detail__info">
                <h4><i class="fas fa-user"></i> Buyer Details</h4>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Name</span>
                    <span class="orders-detail__info-value">{{ $order->buyer_name }}</span>
                </div>
                <div class="orders-detail__info-row">
                    <span class="orders-detail__info-label">Email</span>
                    <span class="orders-detail__info-value">
                        <a href="mailto:{{ $order->buyer_email }}" style="color: var(--gold); text-decoration: none;">
                            {{ $order->buyer_email }}
                        </a>
                    </span>
                </div>
                @if($order->buyer_phone)
                    <div class="orders-detail__info-row">
                        <span class="orders-detail__info-label">Phone</span>
                        <span class="orders-detail__info-value">
                            <a href="tel:{{ $order->buyer_phone }}" style="color: var(--text-muted); text-decoration: none;">
                                {{ $order->buyer_phone }}
                            </a>
                        </span>
                    </div>
                @endif
            </div>

            {{-- ─── RIGHT: Book Details ─── --}}
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
                    <span class="orders-detail__info-value" style="color: var(--gold); font-weight: 700;">
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
                    <span class="orders-detail__info-value" style="font-family: monospace; font-size: 0.8rem;">
                        {{ $order->transaction_id ?? 'N/A' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ─── DOWNLOAD TOKEN ─── --}}
        <div class="orders-detail__download">
            <h4><i class="fas fa-link"></i> Download Token</h4>
            <div class="orders-detail__token">
                <code style="background: var(--bg); padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; word-break: break-all;">
                    {{ $order->download_token }}
                </code>
                <button class="btn btn--secondary btn--sm" onclick="copyToClipboard('{{ $order->download_token }}')" title="Copy token">
                    <i class="fas fa-copy"></i> Copy
                </button>
                <a href="{{ route('payment.download', $order->download_token) }}" target="_blank" class="btn btn--primary btn--sm" title="Test download">
                    <i class="fas fa-download"></i> Test
                </a>
            </div>
            <span style="font-size: 0.75rem; color: var(--text-muted);">
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
            <a href="{{ route('payment.download', $order->download_token) }}" target="_blank" class="btn btn--success" style="background: #25D366; color: #fff;">
                <i class="fas fa-download"></i> Download Book
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/orders.css') }}">
    <style>
        .orders-detail__token {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }
        .orders-detail__token code {
            flex: 1;
            min-width: 200px;
        }
        @media (max-width: 540px) {
            .orders-detail__token {
                flex-direction: column;
                align-items: stretch;
            }
            .orders-detail__token code {
                min-width: unset;
            }
        }
    </style>
@endpush

@push('scripts')
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            showFlashMessage('Token copied to clipboard!', 'success');
        }).catch(function() {
            // Fallback
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