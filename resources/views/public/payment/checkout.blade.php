@extends('layouts.app')

@section('title', 'Redirecting to Payment · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
<div class="payment-checkout">
    <div class="wrap" style="max-width: 600px; margin: 80px auto; text-align: center;">
        <div class="payment-checkout__loader">
            <div class="payment-checkout__spinner">
                <div class="payment-checkout__ring"></div>
                <div class="payment-checkout__ring payment-checkout__ring--2"></div>
                <div class="payment-checkout__ring payment-checkout__ring--3"></div>
            </div>
            <h2 style="margin-top: 24px; font-family: var(--font-serif);">Redirecting to Payment</h2>
            <p style="color: var(--text-muted);">You are being redirected to complete your payment. Please do not close this page.</p>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 8px;">
                <strong>Order:</strong> {{ $order->order_number }} &middot;
                <strong>Amount:</strong> R{{ number_format($order->amount, 2) }}
            </p>
            <button onclick="document.getElementById('paymentForm').submit();" class="btn btn--primary" style="margin-top: 20px;">
                <i class="fas fa-external-link-alt"></i> Continue to Payment
            </button>
        </div>

        {{-- ─── PAYFAST AUTO-SUBMIT FORM ─── --}}
        <form id="paymentForm" method="POST" action="{{ $gateway === 'payfast' ? ($paymentData['is_sandbox'] ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process') : '#' }}" style="display: none;">
            @foreach($paymentData['form_data'] as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
        </form>
    </div>
</div>

@push('styles')
    <style>
        /* ─── CHECKOUT ─── */
        .payment-checkout {
            & .payment-checkout__loader {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 60px 40px;
                background: #fff;
                border-radius: 20px;
                border: 1px solid var(--border);
                box-shadow: var(--shadow);
                max-width: 600px;
                margin: 60px auto;
                text-align: center;

                & h2 {
                    font-family: var(--font-serif);
                    font-size: 1.6rem;
                    margin-top: 24px;
                    color: var(--text);
                }

                & p {
                    color: var(--text-muted);
                    font-size: 1rem;
                    margin: 8px 0 4px;

                    &.payment-checkout__order-details {
                        font-size: 0.85rem;
                        color: var(--text-muted);
                        margin-top: 8px;

                        & strong {
                            color: var(--text);
                        }
                    }
                }

                & .btn {
                    margin-top: 20px;
                    min-height: 48px;
                }
            }

            & .payment-checkout__spinner {
                position: relative;
                width: 80px;
                height: 80px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            & .payment-checkout__ring {
                position: absolute;
                border-radius: 50%;
                border: 3px solid transparent;
                animation: paymentSpin 0.9s cubic-bezier(0.5, 0, 0.5, 1) infinite;

                &.payment-checkout__ring--1 {
                    width: 80px;
                    height: 80px;
                    border-top-color: var(--gold);
                    animation-duration: 0.9s;
                }

                &.payment-checkout__ring--2 {
                    width: 60px;
                    height: 60px;
                    border-top-color: var(--gold-light);
                    animation-duration: 0.7s;
                    animation-direction: reverse;
                }

                &.payment-checkout__ring--3 {
                    width: 40px;
                    height: 40px;
                    border-top-color: var(--gold-dim);
                    animation-duration: 0.5s;
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ─── AUTO-SUBMIT FORM ───
        setTimeout(function() {
            document.getElementById('paymentForm').submit();
        }, 2000);
    });
</script>
@endpush
@endsection