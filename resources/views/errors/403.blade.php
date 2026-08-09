@extends('errors.layout')

@section('title', 'Access Denied · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--danger">
        <i class="fas fa-shield-alt"></i>
    </div>

    <div class="error-page__code">403</div>
    <h1 class="error-page__title">Access Denied</h1>
    <p class="error-page__text">
        You don't have permission to access this page. This could be due to security restrictions or bot detection.
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
        If you believe this is an error, please contact us directly.
    </p>
@endsection