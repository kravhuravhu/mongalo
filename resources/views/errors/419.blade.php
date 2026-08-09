@extends('errors.layout')

@section('title', 'Session Expired · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--warning">
        <i class="fas fa-clock"></i>
    </div>

    <div class="error-page__code">419</div>
    <h1 class="error-page__title">Session Expired</h1>
    <p class="error-page__text">
        Your session has expired. Please refresh the page and try again, or log in again to continue.
    </p>

    <div class="error-page__actions">
        <a href="{{ url()->previous() }}" class="btn btn--primary">
            <i class="fas fa-redo"></i> Refresh & Try Again
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        This usually happens when you've been inactive for a while.
    </p>
@endsection