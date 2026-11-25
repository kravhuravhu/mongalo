@extends('layouts.v160.app')

@section('title', 'Payment Successful · ' . env('PROJECT_NAME', 'The Collective'))

@section('page-class', 'page-payment')

@push('styles')
    @include('components.v160.page-assets')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/payment.css') }}">
@endpush

@section('content')
    @php $paid = $order->payment_status === 'paid'; @endphp
    <div class="page page--payment">
        <x-v160.page-header />
        <div class="page__main payment__main">
            <div class="page__card payment__card">
                {{-- ─── ICON ─── --}}
                <span class="payment__icon {{ $paid ? 'payment__icon--ok' : 'payment__icon--wait' }}">
                    <i class="fa-solid {{ $paid ? 'fa-circle-check' : 'fa-clock' }}" aria-hidden="true"></i>
                </span>

                <h1 class="payment__title">{{ $paid ? 'Payment Successful' : 'Payment Processing' }}</h1>
                <p class="payment__text">
                    @if($paid)
                        Your purchase of <strong>{{ $book->title }}</strong> is complete.
                    @else
                        Your payment for <strong>{{ $book->title }}</strong> is being processed.
                        @if(session('info'))
                            <br><span class="payment__info">{{ session('info') }}</span>
                        @endif
                    @endif
                </p>

                {{-- ─── ORDER DETAILS ─── --}}
                <dl class="payment__details">
                    <div><dt>Order Number</dt><dd class="payment__mono">{{ $order->order_number }}</dd></div>
                    <div><dt>Amount Paid</dt><dd class="payment__gold">R{{ number_format($order->amount, 2) }}</dd></div>
                    <div><dt>Status</dt><dd><span class="payment__badge {{ $paid ? 'payment__badge--ok' : 'payment__badge--wait' }}">{{ $paid ? 'Paid' : 'Pending' }}</span></dd></div>
                    <div><dt>Book</dt><dd>{{ $book->title }}</dd></div>
                </dl>

                {{-- ─── DOWNLOAD (ONLY IF PAID) ─── --}}
                @if($paid)
                    <a href="{{ route('payment.download', $order->download_token) }}" class="page__btn page__btn--primary page__btn--block" download><i class="fa-solid fa-download" aria-hidden="true"></i> Download Book Now</a>
                @else
                    <div class="payment__notice">
                        <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                        <span><strong>Your download will be available once payment is confirmed.</strong><br>You will receive an email confirmation shortly.</span>
                    </div>
                    <span class="page__btn page__btn--ghost page__btn--block payment__disabled"><i class="fa-solid fa-download" aria-hidden="true"></i> Download Unavailable</span>
                @endif
                <div class="payment__actions">
                    <a href="{{ route('books.index', ['open' => $book->slug]) }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-book" aria-hidden="true"></i> View Book</a>
                    <a href="{{ route('home') }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-house" aria-hidden="true"></i> Home</a>
                </div>
                
                <p class="payment__foot">
                    @if($paid)
                        <i class="fa-solid fa-envelope" aria-hidden="true"></i> A confirmation email has been sent to {{ $order->buyer_email }}
                    @else
                        <i class="fa-solid fa-rotate" aria-hidden="true"></i> If you don't receive a confirmation email within 10 minutes, please contact us.
                    @endif
                </p>
            </div>
        </div>
        <x-v160.page-footer />
    </div>
@endsection