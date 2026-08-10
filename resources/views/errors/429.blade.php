@extends('errors.layout')

@section('title', 'Too Many Requests · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--warning">
        <i class="fas fa-tachometer-alt"></i>
    </div>

    <div class="error-page__code">429</div>
    <h1 class="error-page__title">Too Many Requests</h1>
    <p class="error-page__text">
        {{ $message ?? 'You have made too many requests in a short period. Please wait a moment and try again.' }}
    </p>

    @if(isset($retry_after))
        <p class="error-page__text" style="font-size: 1.2rem; font-weight: 600; color: var(--gold);">
            <i class="fas fa-clock"></i>
            Please wait <strong>{{ $retry_after }}</strong> minute(s) before trying again.
        </p>
    @endif

    <div class="error-page__actions">
        <a href="{{ url()->previous() }}" class="btn btn--primary">
            <i class="fas fa-redo"></i> Try Again
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        This limit is in place to protect our servers and ensure fair usage.
    </p>
@endsection