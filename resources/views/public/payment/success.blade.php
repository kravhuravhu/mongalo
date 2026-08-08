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

@endsection