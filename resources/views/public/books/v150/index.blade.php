@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Books & Resources')

@section('content')

@php
    // ─── SEPARATE BOOKS ───
    $featuredBook = $paidBooks->first();
    $secondaryBook = $paidBooks->skip(1)->first();
@endphp

<div class="books">

    {{-- ─── SECTION 1: HERO ─── --}}
    <section class="books__hero">
        <div class="books__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=1920&q=80" 
                alt="Books on a wooden table"
                class="books__hero-bg-img"
                loading="eager"
            >
            <div class="books__hero-overlay"></div>
        </div>

        <div class="wrap">
            <div class="books__hero-content">
                <h1 class="books__hero-title">
                    Books &amp; <span>Resources</span>
                </h1>

                <p class="books__hero-subtitle">
                    Tools for spiritual growth — for the walk ahead.
                </p>
            </div>
        </div>

        <div class="books__hero-count">
            <span class="books__hero-count-num">{{ $paidBooks->count() }}</span>
            <span class="books__hero-count-label">{{ $paidBooks->count() === 1 ? 'Book' : 'Books' }}</span>
        </div>
    </section>

    {{-- ─── SECTION 2: FEATURED BOOK ─── --}}
    @if($featuredBook)
        <section class="books__featured">
            <div class="books__featured-bg">
                <div class="books__featured-shape books__featured-shape--1"></div>
                <div class="books__featured-shape books__featured-shape--2"></div>
            </div>

            <div class="wrap">
                <div class="books__featured-grid">
                    {{-- ─── COVER LEFT ─── --}}
                    <div class="books__featured-cover">
                        <div class="books__featured-cover-book">
                            @if($featuredBook->cover_image)
                                <img 
                                    src="{{ asset('storage/books/covers/' . $featuredBook->cover_image) }}" 
                                    alt="{{ $featuredBook->title }}"
                                    class="books__featured-cover-img"
                                >
                            @else
                                <div class="books__featured-cover-placeholder" style="background: #00ff00;">
                                    <span>[PLACEHOLDER — BOOK COVER]</span>
                                </div>
                            @endif

                            <div class="books__featured-cover-spine"></div>
                            <div class="books__featured-cover-shine"></div>
                        </div>

                        @if($featuredBook->is_featured)
                            <span class="books__featured-badge">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                Bestseller
                            </span>
                        @endif
                    </div>

                    {{-- ─── INFO RIGHT ─── --}}
                    <div class="books__featured-info">
                        <span class="books__featured-eyebrow">Featured Book</span>

                        <h2 class="books__featured-title">
                            {{ $featuredBook->title }}
                        </h2>

                        @if($featuredBook->subtitle)
                            <p class="books__featured-subtitle">
                                {{ $featuredBook->subtitle }}
                            </p>
                        @endif

                        <p class="books__featured-desc">
                            {{ $featuredBook->description }}
                        </p>

                        <div class="books__featured-meta">
                            <span class="books__featured-price">
                                {{ $featuredBook->formatted_price }}
                            </span>

                            @if($featuredBook->file_type)
                                <span class="books__featured-format">
                                    <i class="fas fa-file-{{ $featuredBook->file_type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                                    {{ strtoupper($featuredBook->file_type) }}
                                </span>
                            @endif

                            @if($featuredBook->file_size)
                                <span class="books__featured-size">
                                    <i class="fas fa-hdd"></i>
                                    {{ $featuredBook->file_size }}
                                </span>
                            @endif
                        </div>

                        <div class="books__featured-actions">
                            <a href="{{ route('books.show', $featuredBook->slug) }}" class="btn btn--primary btn--lg">
                                <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                <span>Buy Now</span>
                            </a>

                            <a href="{{ route('books.show', $featuredBook->slug) }}#preview" class="btn btn--outline btn--lg">
                                <i class="fas fa-book-open" aria-hidden="true"></i>
                                <span>Preview</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ─── SECTION 3: SECOND BOOK ─── --}}
    @if($secondaryBook)
        <section class="books__secondary">
            <div class="books__secondary-bg">
                <div class="books__secondary-shape books__secondary-shape--1"></div>
            </div>

            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">Also Available</span>
                    <h2 class="section-header__title">More <span>Reading</span></h2>
                </div>

                <div class="books__secondary-grid">
                    <div class="books__secondary-card">
                        {{-- ─── COVER ─── --}}
                        <div class="books__secondary-cover">
                            @if($secondaryBook->cover_image)
                                <img 
                                    src="{{ asset('storage/books/covers/' . $secondaryBook->cover_image) }}" 
                                    alt="{{ $secondaryBook->title }}"
                                    class="books__secondary-cover-img"
                                >
                            @else
                                <div class="books__secondary-cover-placeholder" style="background: #00ff00;">
                                    <span>[PLACEHOLDER]</span>
                                </div>
                            @endif

                            <div class="books__secondary-cover-spine"></div>
                        </div>

                        {{-- ─── INFO ─── --}}
                        <div class="books__secondary-info">
                            <span class="books__secondary-eyebrow">Book</span>
                            <h3 class="books__secondary-title">{{ $secondaryBook->title }}</h3>

                            @if($secondaryBook->subtitle)
                                <p class="books__secondary-subtitle">{{ $secondaryBook->subtitle }}</p>
                            @endif

                            <p class="books__secondary-desc">
                                {{ Str::limit($secondaryBook->description, 160) }}
                            </p>

                            <div class="books__secondary-meta">
                                <span class="books__secondary-price">
                                    {{ $secondaryBook->formatted_price }}
                                </span>
                            </div>

                            <div class="books__secondary-actions">
                                <a href="{{ route('books.show', $secondaryBook->slug) }}" class="btn btn--primary">
                                    <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                    <span>Buy Now</span>
                                </a>

                                <a href="{{ route('books.show', $secondaryBook->slug) }}#preview" class="btn btn--outline">
                                    <i class="fas fa-book-open" aria-hidden="true"></i>
                                    <span>Preview</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ─── SECTION 4: FREE RESOURCES STRIP ─── --}}
    <section class="books__free-strip">
        <div class="books__free-strip-bg">
            <div class="books__free-strip-shape books__free-strip-shape--1"></div>
            <div class="books__free-strip-shape books__free-strip-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="books__free-strip-content">
                <div class="books__free-strip-icon">
                    <i class="fas fa-file-pdf"></i>
                </div>

                <div class="books__free-strip-text">
                    <h3 class="books__free-strip-title">
                        Looking for free resources?
                    </h3>
                    <p class="books__free-strip-desc">
                        Booklets, pamphlets, free Bibles and study guides — all available at no cost.
                    </p>
                </div>

                <a href="{{ route('resources') }}" class="books__free-strip-btn">
                    <span>Browse Free Resources</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: COMMUNITY CTA ─── --}}
    <section class="books__community">
        <div class="books__community-bg">
            <div class="books__community-shape books__community-shape--1"></div>
            <div class="books__community-shape books__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="books__community-content">
                <div class="books__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="books__community-title">
                    Get updates on <span>new releases</span>
                </h2>

                <p class="books__community-desc">
                    Join the community and be the first to know when a new book or resource drops.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/books.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/books.css') }}">
@endpush

@endsection