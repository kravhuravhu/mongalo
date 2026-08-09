@extends('errors.layout')

@section('title', 'Page Not Found · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')
    <div class="error-page__icon error-page__icon--warning">
        <i class="fas fa-search"></i>
    </div>

    <div class="error-page__code">404</div>
    <h1 class="error-page__title">Page Not Found</h1>
    <p class="error-page__text">
        We couldn't find the page you were looking for. It may have been moved, deleted, or never existed.
    </p>

    <div class="error-page__actions">
        <a href="{{ route('home') }}" class="btn btn--primary">
            <i class="fas fa-home"></i> Return Home
        </a>
        <a href="{{ route('books.index') }}" class="btn btn--secondary">
            <i class="fas fa-book"></i> Browse Books
        </a>
        <a href="{{ route('contact') }}" class="btn btn--secondary">
            <i class="fas fa-envelope"></i> Need Help?
        </a>
    </div>

    <p class="error-page__help">
        <i class="fas fa-info-circle"></i>
        If you followed a broken link, please let us know.
    </p>
@endsection