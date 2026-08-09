@extends('errors.layout')

@section('title', 'Service Unavailable · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--info">
        <i class="fas fa-tools"></i>
    </div>

    <div class="error-page__code">503</div>
    <h1 class="error-page__title">Service Unavailable</h1>
    <p class="error-page__text">
        We're currently performing maintenance or experiencing high traffic. Please check back soon.
    </p>

    <div class="error-page__actions">
        <a href="{{ route('home') }}" class="btn btn--primary">
            <i class="fas fa-home"></i> Return Home
        </a>
        <a href="{{ route('contact') }}" class="btn btn--secondary">
            <i class="fas fa-envelope"></i> Contact Support
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        We'll be back online shortly. Thank you for your patience.
    </p>
@endsection