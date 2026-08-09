@extends('errors.layout')

@section('title', 'Unauthorized · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--warning">
        <i class="fas fa-lock"></i>
    </div>

    <div class="error-page__code">401</div>
    <h1 class="error-page__title">Unauthorized Access</h1>
    <p class="error-page__text">
        You need to be logged in to access this page. Please sign in to continue.
    </p>

    <div class="error-page__actions">
        <a href="{{ route('admin.login') }}" class="btn btn--primary">
            <i class="fas fa-sign-in-alt"></i> Sign In
        </a>
        <a href="{{ route('home') }}" class="btn btn--secondary">
            <i class="fas fa-home"></i> Return Home
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        If you believe this is an error, please contact support.
    </p>
@endsection