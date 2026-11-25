@extends('layouts.v160.app')

@section('title', 'Payment Failed · ' . env('PROJECT_NAME', 'IN.iN'))

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
                <span class="payment__icon payment__icon--fail"><i class="fa-solid fa-circle-xmark" aria-hidden="true"></i></span>
                <h1 class="payment__title">Payment Not Completed</h1>
                <p class="payment__text">{{ $message ?? 'Your payment was not completed. Please try again.' }}</p>
                @if($order)
                    <dl class="payment__details">
                        <div><dt>Order Number</dt><dd class="payment__mono">{{ $order->order_number }}</dd></div>
                        <div><dt>Book</dt><dd>{{ $order->book->title ?? 'N/A' }}</dd></div>
                    </dl>
                @endif
                <div class="payment__actions">
                    @if($order)
                        <a href="{{ route('books.index', ['open' => $order->book->slug]) }}" class="page__btn page__btn--primary"><i class="fa-solid fa-rotate-right" aria-hidden="true"></i> Try Again</a>
                    @else
                        <a href="{{ route('books.index') }}" class="page__btn page__btn--primary"><i class="fa-solid fa-book" aria-hidden="true"></i> Browse Books</a>
                    @endif
                    <a href="{{ route('contact') }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-envelope" aria-hidden="true"></i> Need Help?</a>
                </div>
                <p class="payment__foot"><i class="fa-solid fa-circle-info" aria-hidden="true"></i> If you were charged but didn't receive your download, please contact us.</p>
            </div>
        </div>
        <x-v160.page-footer />
    </div>
@endsection