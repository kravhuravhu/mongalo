@extends('layouts.app')

@section('title', 'Payment Failed · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="payment-failure">
    <div class="wrap" style="max-width: 600px; margin: 60px auto;">
        <div class="payment-failure__card" style="background: #fff; border-radius: 20px; padding: 48px 40px; border: 1px solid var(--border); box-shadow: var(--shadow); text-align: center;">
            {{-- ─── ICON ─── --}}
            <div style="width: 80px; height: 80px; border-radius: 50%; background: #f8d7da; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                <i class="fas fa-times-circle" style="font-size: 2.8rem; color: #dc3545;"></i>
            </div>

            <h1 style="font-family: var(--font-serif); font-weight: 900; font-size: 2rem; margin-bottom: 8px;">
                Payment Not Completed
            </h1>
            <p style="color: var(--text-muted); font-size: 1.05rem; margin-bottom: 24px;">
                {{ $message ?? 'Your payment was not completed. Please try again.' }}
            </p>

            @if($order)
                <div style="background: var(--bg); border-radius: 12px; padding: 20px 24px; margin-bottom: 24px; text-align: left;">
                    <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid var(--border);">
                        <span style="color: var(--text-muted);">Order Number</span>
                        <span style="font-weight: 600; font-family: monospace;">{{ $order->order_number }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 6px 0;">
                        <span style="color: var(--text-muted);">Book</span>
                        <span style="font-weight: 600;">{{ $order->book->title ?? 'N/A' }}</span>
                    </div>
                </div>
            @endif

            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                @if($order)
                    <a href="{{ route('books.show', $order->book->slug) }}" class="btn btn--primary" style="flex: 1; justify-content: center;">
                        <i class="fas fa-redo"></i> Try Again
                    </a>
                @else
                    <a href="{{ route('books.index') }}" class="btn btn--primary" style="flex: 1; justify-content: center;">
                        <i class="fas fa-book"></i> Browse Books
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="btn btn--secondary" style="flex: 1; justify-content: center;">
                    <i class="fas fa-envelope"></i> Need Help?
                </a>
            </div>

            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 20px;">
                <i class="fas fa-info-circle"></i> 
                If you were charged but didn't receive your download, please contact us.
            </p>
        </div>
    </div>
</div>

@endsection