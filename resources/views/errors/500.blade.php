@extends('errors.layout')

@section('title', 'Server Error · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--danger">
        <i class="fas fa-exclamation-triangle"></i>
    </div>

    <div class="error-page__code">500</div>
    <h1 class="error-page__title">Something Went Wrong</h1>
    <p class="error-page__text">
        We're experiencing technical difficulties. Our team has been notified and is working on a fix. Please try again later.
    </p>

    <div class="error-page__actions">
        <a href="{{ url()->previous() }}" class="btn btn--primary">
            <i class="fas fa-redo"></i> Try Again
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
        <a href="{{ route('contact') }}" class="btn btn--secondary">
            <i class="fas fa-envelope"></i> Contact Support
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        We apologize for the inconvenience. Please try again in a few minutes.
    </p>
@endsection