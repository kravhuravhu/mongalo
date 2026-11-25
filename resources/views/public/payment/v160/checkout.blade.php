@extends('layouts.v160.app')

@section('title', 'Redirecting to Payment · ' . env('PROJECT_NAME', 'IN.iN'))

@section('page-class', 'page-payment')

@push('styles')
    @include('components.v160.page-assets')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/payment.css') }}">
@endpush

@section('content')
    <div class="page page--payment">
        <x-v160.page-header />
        <div class="page__main payment__main">
            <div class="page__card payment__card">
                <div class="payment__spinner">
                    <span class="payment__ring"></span>
                    <span class="payment__ring payment__ring--2"></span>
                    <span class="payment__ring payment__ring--3"></span>
                </div>
                <h1 class="payment__title">Redirecting to Payment</h1>
                <p class="payment__text">You are being redirected to complete your payment. Please do not close this page.</p>
                <p class="payment__meta"><strong>Order:</strong> {{ $order->order_number }} &middot; <strong>Amount:</strong> R{{ number_format($order->amount, 2) }}</p>
                <button type="button" class="page__btn page__btn--primary" id="paymentContinue"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> Continue to Payment</button>
                {{-- ─── PAYFAST AUTO-SUBMIT FORM ─── --}}
                <form id="paymentForm" method="POST" action="{{ $gateway === 'payfast' ? ($paymentData['is_sandbox'] ? 'https://sandbox.payfast.co.za/eng/process' : 'https://www.payfast.co.za/eng/process') : '#' }}" hidden>
                    @foreach($paymentData['form_data'] as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>
            </div>
        </div>
        <x-v160.page-footer />
    </div>
@endsection

@push('scripts')
    <script src="{{ secure_asset('js/v160/payment.js') }}"></script>
@endpush