@extends('layouts.app')

@section('title', $book->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="book-detail">

    <!-- ─── HERO ─── -->
    <section class="book-detail__hero" style="background: linear-gradient(165deg, {{ $book->cover_color }}15 0%, #f7f5f2 100%);">
        <div class="wrap">
            <div class="book-detail__grid">
                <div class="book-detail__cover">
                    <div class="book-detail__placeholder" style="background:{{ $book->cover_color }};">
                        <span class="book-detail__placeholder-title">{{ $book->title }}</span>
                        <small class="book-detail__placeholder-author">Arthur Mongalo</small>
                    </div>
                </div>
                <div class="book-detail__info">
                    <span class="book-detail__eyebrow">Book</span>
                    <h1 class="book-detail__title">{{ $book->title }}</h1>
                    <p class="book-detail__subtitle">{{ $book->subtitle }}</p>
                    <div class="book-detail__meta">
                        <span class="book-detail__price">{{ $book->price }}</span>
                        @if($book->is_featured)
                            <span class="book-detail__badge">★ Bestseller</span>
                        @endif
                        @if($book->is_free)
                            <span class="book-detail__badge book-detail__badge--free">Free</span>
                        @endif
                    </div>
                    <p class="book-detail__desc">{{ $book->description }}</p>
                    <div class="book-detail__actions">
                        <a href="#" class="btn btn--primary">
                            <i class="fas fa-shopping-cart"></i> Order Now
                        </a>
                        <a href="#" class="btn btn--outline">
                            <i class="fas fa-book-open"></i> Preview
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── RELATED BOOKS ─── -->
    @if($relatedBooks->count() > 0)
    <section class="book-detail__related">
        <div class="wrap">
            <div class="book-detail__related-header">
                <span class="book-detail__related-eyebrow">You Might Also Like</span>
                <h2 class="book-detail__related-title">Related <span>Books</span></h2>
            </div>

            <div class="book-detail__related-grid">
                @foreach($relatedBooks as $related)
                <div class="book-detail__related-card">
                    <div class="book-detail__related-cover" style="background:{{ $related->cover_color }};">
                        <span class="book-detail__related-cover-title">{{ $related->title }}</span>
                    </div>
                    <div class="book-detail__related-info">
                        <h4 class="book-detail__related-name">{{ $related->title }}</h4>
                        <span class="book-detail__related-price">{{ $related->price }}</span>
                        <a href="{{ route('books.show', $related->slug) }}" class="btn btn--primary btn--sm">View Details</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</div>

@push('scripts')
    <script src="{{ secure_asset('js/books.js') }}"></script>
@endpush

@endsection