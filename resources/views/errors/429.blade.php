@extends('errors.layout')

@section('title', 'Too Many Requests · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--warning">
        <i class="fas fa-tachometer-alt"></i>
    </div>

    <div class="error-page__code">429</div>
    <h1 class="error-page__title">Too Many Requests</h1>
    <p class="error-page__text">
        You have made too many requests in a short period. Please wait a moment and try again.
    </p>

    <div class="error-page__actions">
        <a href="{{ url()->current() }}" class="btn btn--primary">
            <i class="fas fa-redo"></i> Try Again
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        Please wait a few minutes before making another request.
    </p>
@endsection