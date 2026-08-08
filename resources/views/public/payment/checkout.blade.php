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
    .payment-checkout__loader {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: #fff;
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
    }
    
    .payment-checkout__spinner {
        position: relative;
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .payment-checkout__ring {
        position: absolute;
        border-radius: 50%;
        border: 3px solid transparent;
        animation: paymentSpin 0.9s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    }
    
    .payment-checkout__ring--1 {
        width: 80px;
        height: 80px;
        border-top-color: var(--gold);
        animation-duration: 0.9s;
    }
    
    .payment-checkout__ring--2 {
        width: 60px;
        height: 60px;
        border-top-color: var(--gold-light);
        animation-duration: 0.7s;
        animation-direction: reverse;
    }
    
    .payment-checkout__ring--3 {
        width: 40px;
        height: 40px;
        border-top-color: var(--gold-dim);
        animation-duration: 0.5s;
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