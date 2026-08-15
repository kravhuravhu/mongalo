@extends('layouts.app')

@section('title', 'Payment Successful · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="payment-success">
    <div class="wrap" style="max-width: 600px; margin: 60px auto;">
        <div class="payment-success__card" style="background: #fff; border-radius: 20px; padding: 48px 40px; border: 1px solid var(--border); box-shadow: var(--shadow); text-align: center;">
            {{-- ─── ICON ─── --}}
            <div style="width: 80px; height: 80px; border-radius: 50%; background: {{ $order->payment_status === 'paid' ? '#d4edda' : '#fff3cd' }}; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                @if($order->payment_status === 'paid')
                    <i class="fas fa-check-circle" style="font-size: 2.8rem; color: #28a745;"></i>
                @else
                    <i class="fas fa-clock" style="font-size: 2.8rem; color: #e8a838;"></i>
                @endif
            </div>

            <h1 style="font-family: var(--font-serif); font-weight: 900; font-size: 2rem; margin-bottom: 8px;">
                @if($order->payment_status === 'paid')
                    Payment Successful
                @else
                    Payment Processing
                @endif
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 24px;">
                @if($order->payment_status === 'paid')
                    Your purchase of <strong>{{ $book->title }}</strong> is complete.
                @else
                    Your payment for <strong>{{ $book->title }}</strong> is being processed.
                    @if(session('info'))
                        <br><span style="font-size: 0.9rem; color: #856404;">{{ session('info') }}</span>
                    @endif
                @endif
            </p>

            {{-- ─── ORDER DETAILS ─── --}}
            <div style="background: var(--bg); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; text-align: left;">
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: var(--text-muted);">Order Number</span>
                    <span style="font-weight: 600; font-family: monospace;">{{ $order->order_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: var(--text-muted);">Amount Paid</span>
                    <span style="font-weight: 700; color: var(--gold);">R{{ number_format($order->amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--border);">
                    <span style="color: var(--text-muted);">Status</span>
                    <span>
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-completed"><i class="fas fa-check-circle"></i> Paid</span>
                        @else
                            <span class="badge badge-pending"><i class="fas fa-clock"></i> Pending</span>
                        @endif
                    </span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                    <span style="color: var(--text-muted);">Book</span>
                    <span style="font-weight: 600;">{{ $book->title }}</span>
                </div>
            </div>

            {{-- ─── DOWNLOAD BUTTON (Only if paid) ─── --}}
            @if($order->payment_status === 'paid')
                <a href="{{ route('payment.download', $order->download_token) }}" class="btn btn--primary btn--lg" style="width: 100%; justify-content: center; margin-bottom: 12px;">
                    <i class="fas fa-download"></i> Download Book Now
                </a>
            @else
                <div style="background: #fff3cd; color: #856404; padding: 16px 20px; border-radius: 10px; margin-bottom: 16px; border-left: 4px solid #e8a838; text-align: left;">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Your download will be available once payment is confirmed.</strong>
                    <br>
                    <span style="font-size: 0.85rem;">You will receive an email confirmation shortly.</span>
                </div>
                <a href="#" class="btn btn--secondary btn--lg" style="width: 100%; justify-content: center; margin-bottom: 12px; opacity: 0.6; cursor: not-allowed;" onclick="event.preventDefault();">
                    <i class="fas fa-download"></i> Download Unavailable
                </a>
            @endif

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('books.show', $book->slug) }}" class="btn btn--secondary" style="flex: 1; justify-content: center;">
                    <i class="fas fa-book"></i> View Book
                </a>
                <a href="{{ route('home') }}" class="btn btn--secondary" style="flex: 1; justify-content: center;">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>

            @if($order->payment_status !== 'paid')
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 20px;">
                    <i class="fas fa-sync-alt"></i> 
                    If you don't receive a confirmation email within 10 minutes, please contact us.
                </p>
            @else
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 20px;">
                    <i class="fas fa-envelope"></i> A confirmation email has been sent to {{ $order->buyer_email }}
                </p>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* ─── SUCCESS ─── */
        .payment-success {
            & .payment-success__card {
                background: #fff;
                border-radius: 20px;
                padding: 48px 40px;
                border: 1px solid var(--border);
                box-shadow: var(--shadow);
                max-width: 600px;
                margin: 60px auto;
                text-align: center;

                & .payment-success__icon {
                    width: 80px;
                    height: 80px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 0 auto 20px;

                    &.payment-success__icon--paid {
                        background: #d4edda;

                        & i {
                            font-size: 2.8rem;
                            color: #28a745;
                        }
                    }

                    &.payment-success__icon--pending {
                        background: #fff3cd;

                        & i {
                            font-size: 2.8rem;
                            color: #e8a838;
                        }
                    }
                }

                & h1 {
                    font-family: var(--font-serif);
                    font-weight: 900;
                    font-size: 2rem;
                    margin-bottom: 8px;
                    color: var(--text);
                }

                & .payment-success__subtitle {
                    color: var(--text-muted);
                    font-size: 1.05rem;
                    margin-bottom: 24px;

                    & strong {
                        color: var(--text);
                    }

                    & .payment-success__info {
                        font-size: 0.9rem;
                        color: #856404;
                        display: block;
                        margin-top: 4px;
                    }
                }

                & .payment-success__details {
                    background: var(--bg);
                    border-radius: 12px;
                    padding: 20px 24px;
                    margin-bottom: 24px;
                    text-align: left;

                    & .payment-success__detail-row {
                        display: flex;
                        justify-content: space-between;
                        padding: 6px 0;
                        border-bottom: 1px solid var(--border);

                        &:last-child {
                            border-bottom: none;
                        }

                        & .label {
                            color: var(--text-muted);
                            font-size: 0.85rem;
                        }

                        & .value {
                            font-weight: 600;
                            font-size: 0.85rem;
                            color: var(--text);

                            &.value--gold {
                                color: var(--gold);
                            }

                            &.value--mono {
                                font-family: monospace;
                            }
                        }
                    }
                }

                & .payment-success__actions {
                    display: flex;
                    gap: 12px;
                    flex-wrap: wrap;

                    & .btn {
                        flex: 1;
                        justify-content: center;
                        min-height: 48px;

                        &.btn--primary {
                            background: var(--gold);
                            color: #fff;

                            &:hover {
                                background: var(--gold-light);
                            }
                        }

                        &.btn--secondary {
                            background: var(--bg);
                            color: var(--text);
                            border: 1px solid var(--border);

                            &:hover {
                                background: var(--gold-dim);
                            }
                        }

                        &.btn--disabled {
                            opacity: 0.6;
                            cursor: not-allowed;

                            &:hover {
                                transform: none !important;
                            }
                        }
                    }
                }

                & .payment-success__note {
                    font-size: 0.8rem;
                    color: var(--text-muted);
                    margin-top: 20px;

                    & i {
                        margin-right: 4px;
                    }
                }

                & .payment-success__pending-note {
                    background: #fff3cd;
                    color: #856404;
                    padding: 16px 20px;
                    border-radius: 10px;
                    margin-bottom: 16px;
                    border-left: 4px solid #e8a838;
                    text-align: left;

                    & i {
                        margin-right: 8px;
                    }

                    & strong {
                        color: #856404;
                    }

                    & .payment-success__pending-note-sub {
                        display: block;
                        font-size: 0.85rem;
                        margin-top: 4px;
                    }
                }
            }
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 1200px) {
            .payment-checkout .payment-checkout__loader {
                padding: 48px 32px;
                margin: 40px 20px;
            }

            .payment-checkout .payment-checkout__loader h2 {
                font-size: 1.4rem;
            }

            .payment-success .payment-success__card {
                padding: 40px 32px;
                margin: 40px 20px;
            }

            .payment-success .payment-success__card h1 {
                font-size: 1.8rem;
            }

            .payment-failure .payment-failure__card {
                padding: 40px 32px;
                margin: 40px 20px;
            }

            .payment-failure .payment-failure__card h1 {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 1024px) {
            .payment-success .payment-success__card .payment-success__actions {
                flex-direction: column;
            }

            .payment-success .payment-success__card .payment-success__actions .btn {
                width: 100%;
            }

            .payment-failure .payment-failure__card .payment-failure__actions {
                flex-direction: column;
            }

            .payment-failure .payment-failure__card .payment-failure__actions .btn {
                width: 100%;
            }
        }

        @media (max-width: 820px) {
            .payment-checkout .payment-checkout__loader {
                padding: 36px 24px;
                border-radius: 16px;
            }

            .payment-checkout .payment-checkout__loader h2 {
                font-size: 1.2rem;
                margin-top: 16px;
            }

            .payment-checkout .payment-checkout__loader p {
                font-size: 0.9rem;
            }

            .payment-checkout .payment-checkout__loader .btn {
                min-height: 40px;
                font-size: 0.8rem;
            }

            .payment-success .payment-success__card {
                padding: 32px 24px;
                border-radius: 16px;
            }

            .payment-success .payment-success__card h1 {
                font-size: 1.5rem;
            }

            .payment-success .payment-success__card .payment-success__subtitle {
                font-size: 0.95rem;
            }

            .payment-success .payment-success__card .payment-success__details {
                padding: 16px 18px;
            }

            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row {
                padding: 4px 0;
            }

            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row .label,
            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row .value {
                font-size: 0.8rem;
            }

            .payment-success .payment-success__card .payment-success__actions .btn {
                min-height: 40px;
                font-size: 0.8rem;
            }

            .payment-failure .payment-failure__card {
                padding: 32px 24px;
                border-radius: 16px;
            }

            .payment-failure .payment-failure__card h1 {
                font-size: 1.5rem;
            }

            .payment-failure .payment-failure__card .payment-failure__subtitle {
                font-size: 0.95rem;
            }

            .payment-failure .payment-failure__card .payment-failure__details {
                padding: 16px 18px;
            }

            .payment-failure .payment-failure__card .payment-failure__actions .btn {
                min-height: 40px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 540px) {
            .payment-checkout .payment-checkout__loader {
                padding: 28px 16px;
                margin: 30px 12px;
            }

            .payment-checkout .payment-checkout__loader h2 {
                font-size: 1rem;
            }

            .payment-checkout .payment-checkout__loader p {
                font-size: 0.8rem;
            }

            .payment-checkout .payment-checkout__loader .btn {
                min-height: 36px;
                font-size: 0.7rem;
                padding: 8px 16px;
            }

            .payment-checkout .payment-checkout__spinner {
                width: 60px;
                height: 60px;
            }

            .payment-checkout .payment-checkout__ring--1 {
                width: 60px;
                height: 60px;
            }

            .payment-checkout .payment-checkout__ring--2 {
                width: 45px;
                height: 45px;
            }

            .payment-checkout .payment-checkout__ring--3 {
                width: 30px;
                height: 30px;
            }

            .payment-success .payment-success__card {
                padding: 24px 16px;
                margin: 20px 12px;
            }

            .payment-success .payment-success__card .payment-success__icon {
                width: 60px;
                height: 60px;
            }

            .payment-success .payment-success__card .payment-success__icon i {
                font-size: 2rem;
            }

            .payment-success .payment-success__card h1 {
                font-size: 1.3rem;
            }

            .payment-success .payment-success__card .payment-success__subtitle {
                font-size: 0.85rem;
            }

            .payment-success .payment-success__card .payment-success__details {
                padding: 12px 14px;
            }

            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row {
                flex-direction: column;
                align-items: center;
                gap: 2px;
                padding: 4px 0;
            }

            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row .label,
            .payment-success .payment-success__card .payment-success__details .payment-success__detail-row .value {
                font-size: 0.75rem;
            }

            .payment-success .payment-success__card .payment-success__actions .btn {
                min-height: 36px;
                font-size: 0.75rem;
                padding: 8px 14px;
            }

            .payment-success .payment-success__card .payment-success__note {
                font-size: 0.7rem;
            }

            .payment-failure .payment-failure__card {
                padding: 24px 16px;
                margin: 20px 12px;
            }

            .payment-failure .payment-failure__card .payment-failure__icon {
                width: 60px;
                height: 60px;
            }

            .payment-failure .payment-failure__card .payment-failure__icon i {
                font-size: 2rem;
            }

            .payment-failure .payment-failure__card h1 {
                font-size: 1.3rem;
            }

            .payment-failure .payment-failure__card .payment-failure__subtitle {
                font-size: 0.85rem;
            }

            .payment-failure .payment-failure__card .payment-failure__details {
                padding: 12px 14px;
            }

            .payment-failure .payment-failure__card .payment-failure__details .payment-failure__detail-row {
                flex-direction: column;
                align-items: center;
                gap: 2px;
                padding: 4px 0;
            }

            .payment-failure .payment-failure__card .payment-failure__details .payment-failure__detail-row .label,
            .payment-failure .payment-failure__card .payment-failure__details .payment-failure__detail-row .value {
                font-size: 0.75rem;
            }

            .payment-failure .payment-failure__card .payment-failure__actions .btn {
                min-height: 36px;
                font-size: 0.75rem;
                padding: 8px 14px;
            }

            .payment-failure .payment-failure__card .payment-failure__note {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 420px) {
            .payment-checkout .payment-checkout__loader {
                padding: 20px 12px;
                margin: 20px 8px;
            }

            .payment-checkout .payment-checkout__loader h2 {
                font-size: 0.9rem;
            }

            .payment-checkout .payment-checkout__loader p {
                font-size: 0.7rem;
            }

            .payment-checkout .payment-checkout__loader .btn {
                min-height: 32px;
                font-size: 0.6rem;
                padding: 4px 12px;
            }

            .payment-checkout .payment-checkout__spinner {
                width: 50px;
                height: 50px;
            }

            .payment-checkout .payment-checkout__ring--1 {
                width: 50px;
                height: 50px;
            }

            .payment-checkout .payment-checkout__ring--2 {
                width: 38px;
                height: 38px;
            }

            .payment-checkout .payment-checkout__ring--3 {
                width: 26px;
                height: 26px;
            }

            .payment-success .payment-success__card {
                padding: 18px 12px;
                margin: 16px 8px;
            }

            .payment-success .payment-success__card .payment-success__icon {
                width: 48px;
                height: 48px;
            }

            .payment-success .payment-success__card .payment-success__icon i {
                font-size: 1.6rem;
            }

            .payment-success .payment-success__card h1 {
                font-size: 1.1rem;
            }

            .payment-failure .payment-failure__card {
                padding: 18px 12px;
                margin: 16px 8px;
            }

            .payment-failure .payment-failure__card .payment-failure__icon {
                width: 48px;
                height: 48px;
            }

            .payment-failure .payment-failure__card .payment-failure__icon i {
                font-size: 1.6rem;
            }

            .payment-failure .payment-failure__card h1 {
                font-size: 1.1rem;
            }
        }

        @keyframes paymentSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@endsection