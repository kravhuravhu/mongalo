@extends('errors.layout')

@section('title', 'Security Error · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--danger">
        <i class="fas fa-shield-virus"></i>
    </div>

    <div class="error-page__code">419</div>
    <h1 class="error-page__title">Security Error</h1>
    <p class="error-page__text">
        The security token for this request has expired or is invalid. Please refresh the page and try again.
    </p>

    <div class="error-page__actions">
        <a href="{{ url()->current() }}" class="btn btn--primary">
            <i class="fas fa-redo"></i> Refresh Page
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        This is a security measure to protect your data. Please refresh and try again.
    </p>
@endsection