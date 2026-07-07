@extends('layouts.app')

@section('title', 'The Collective · Books')

@section('content')

@php
    // Divine Identity
    $divineBook = $paidBooks->first(function($book) {
        return str_contains(strtolower($book->title), 'divine') || str_contains(strtolower($book->title), 'identity');
    }) ?? $paidBooks->first();
@endphp

<div class="books">

    <!-- ─── HERO BANNER ─── -->
    <section class="books__hero">
        <div class="books__hero-bg">
            <div class="books__hero-pattern"></div>
            <div class="books__hero-shape books__hero-shape--1"></div>
            <div class="books__hero-shape books__hero-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="books__hero-banner">
                <div class="books__hero-content">
                    <span class="books__hero-badge">
                        <i class="fas fa-book-open" aria-hidden="true"></i>
                        Library
                    </span>
                    <h1 class="books__hero-title">
                        Explore the
                        <span class="books__hero-title-highlight">Collection</span>
                    </h1>
                    <p class="books__hero-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="books__hero-search">
                        <div class="books__hero-search-wrapper">
                            <i class="fas fa-search" aria-hidden="true"></i>
                            <input type="text" placeholder="Search for a book..." class="books__hero-search-input">
                            <button class="books__hero-search-btn">Search</button>
                        </div>
                    </div>
                    <div class="books__hero-stats">
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $paidBooks->count() + $freeBooks->count() }}</span>
                            <span class="books__hero-stat-label">Total Books</span>
                        </div>
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $paidBooks->count() }}</span>
                            <span class="books__hero-stat-label">Paid</span>
                        </div>
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $freeBooks->count() }}</span>
                            <span class="books__hero-stat-label">Free</span>
                        </div>
                    </div>
                </div>

                <div class="books__hero-shelf">
                    <div class="books__hero-shelf-row">
                        <div class="books__hero-shelf-book" style="background:#8B5E3C;animation-delay:0s;">
                            <span class="books__hero-shelf-title">Divine Identity</span>
                        </div>
                        <div class="books__hero-shelf-book" style="background:#a67c4e;animation-delay:0.15s;">
                            <span class="books__hero-shelf-title">The Journey</span>
                        </div>
                        <div class="books__hero-shelf-book" style="background:#5C3D2E;animation-delay:0.3s;">
                            <span class="books__hero-shelf-title">Faith Unveiled</span>
                        </div>
                    </div>
                    <div class="books__hero-shelf-row">
                        <div class="books__hero-shelf-book" style="background:#c69a6a;animation-delay:0.45s;">
                            <span class="books__hero-shelf-title">Identity</span>
                        </div>
                        <div class="books__hero-shelf-book" style="background:#8B5E3C;animation-delay:0.6s;">
                            <span class="books__hero-shelf-title">Purpose</span>
                        </div>
                        <div class="books__hero-shelf-book" style="background:#a67c4e;animation-delay:0.75s;">
                            <span class="books__hero-shelf-title">Grace</span>
                        </div>
                    </div>
                    <div class="books__hero-shelf-divider"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── CATEGORY PILLS ─── -->
    <section class="books__categories">
        <div class="wrap">
            <div class="books__categories-list">
                <button class="books__categories-pill books__categories-pill--active">
                    <i class="fas fa-th-large"></i>
                    All
                </button>
                <button class="books__categories-pill">
                    <i class="fas fa-star"></i>
                    Featured
                </button>
                <button class="books__categories-pill">
                    <i class="fas fa-book"></i>
                    Paperback
                </button>
                <button class="books__categories-pill">
                    <i class="fas fa-file-pdf"></i>
                    Digital
                </button>
                <button class="books__categories-pill">
                    <i class="fas fa-gift"></i>
                    Free
                </button>
            </div>
        </div>
    </section>

    <!-- ─── BOOKS GRID MASONRY ─── -->
    <section class="books__grid" id="books-grid">
        <div class="wrap">
            <div class="books__grid-header">
                <span class="books__grid-eyebrow">Collection</span>
                <h2 class="books__grid-title">All <span>Books</span></h2>
            </div>

            <div class="books__grid-masonry">
                @forelse($paidBooks as $index => $book)
                <div class="books__grid-item books__grid-item--{{ ($index % 3) + 1 }}" style="animation-delay: {{ $index * 0.06 }}s;">
                    <div class="books__grid-card">
                        <div class="books__grid-cover" style="background:{{ $book->cover_color ?? '#a67c4e' }};">
                            <span class="books__grid-cover-title">{{ $book->title }}</span>
                            @if($book->is_featured)
                                <span class="books__grid-cover-badge">★ Featured</span>
                            @endif
                            <div class="books__grid-cover-shine"></div>
                        </div>
                        <div class="books__grid-info">
                            <h4 class="books__grid-name">{{ $book->title }}</h4>
                            <p class="books__grid-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <div class="books__grid-footer">
                                <span class="books__grid-price">{{ $book->price }}</span>
                                <a href="{{ route('books.show', $book->slug) }}" class="books__grid-btn">
                                    <span>Details</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <p class="books__grid-empty">No books available yet. Check back soon!</p>
                @endforelse

                @forelse($freeBooks as $index => $book)
                <div class="books__grid-item books__grid-item--free" style="animation-delay: {{ ($paidBooks->count() + $index) * 0.06 }}s;">
                    <div class="books__grid-card books__grid-card--free">
                        <div class="books__grid-cover" style="background:{{ $book->cover_color ?? '#6a6a7a' }};">
                            <span class="books__grid-cover-title">{{ $book->title }}</span>
                            <span class="books__grid-cover-badge books__grid-cover-badge--free">Free</span>
                            <div class="books__grid-cover-shine"></div>
                        </div>
                        <div class="books__grid-info">
                            <h4 class="books__grid-name">{{ $book->title }}</h4>
                            <p class="books__grid-desc">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </p>
                            <div class="books__grid-footer">
                                <span class="books__grid-price books__grid-price--free">Free</span>
                                <a href="{{ route('books.show', $book->slug) }}" class="books__grid-btn books__grid-btn--free">
                                    <span>Download</span>
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── FEATURED AUTHOR ─── -->
    <section class="books__author">
        <div class="books__author-bg">
            <span class="books__author-tag">AUTHOR</span>
            <div class="books__author-shape books__author-shape--1"></div>
            <div class="books__author-shape books__author-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="books__author-container">
                <div class="books__author-content">
                    <span class="books__author-eyebrow">Meet the Author</span>
                    <h2 class="books__author-title">Arthur <span>Mongalo</span></h2>
                    <p class="books__author-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p class="books__author-text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    </p>
                    <div class="books__author-quote">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                        <blockquote>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                        </blockquote>
                    </div>
                </div>

                <div class="books__author-visual">
                    <div class="books__author-card">
                        <div class="books__author-card-icon">
                            <i class="fas fa-user-pen"></i>
                        </div>
                        <div class="books__author-card-name">Arthur Mongalo</div>
                        <div class="books__author-card-role">Author · Speaker</div>
                        <div class="books__author-card-line"></div>
                        <div class="books__author-card-socials">
                            <a href="#" class="books__author-card-social">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="books__author-card-social">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="books__author-card-social">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── DIVINE IDENTITY SPOTLIGHT ─── -->
    @if($divineBook)
    <section class="books__divine">
        <div class="books__divine-bg">
            <span class="books__divine-tag">DIVINE IDENTITY</span>
            <div class="books__divine-shape books__divine-shape--1"></div>
            <div class="books__divine-shape books__divine-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="books__divine-container">
                <div class="books__divine-card">
                    <div class="books__divine-card-inner" style="background:{{ $divineBook->cover_color ?? '#8B5E3C' }};">
                        <div class="books__divine-card-title">{{ $divineBook->title }}</div>
                        <div class="books__divine-card-divider"></div>
                        <div class="books__divine-card-author">Arthur Mongalo</div>
                        <div class="books__divine-card-shine"></div>
                    </div>
                    <div class="books__divine-card-floating">
                        <div class="books__divine-card-floating-content">
                            <span class="books__divine-card-floating-icon">
                                <i class="fas fa-shopping-bag"></i>
                            </span>
                            <span class="books__divine-card-floating-title">Get Your Copy</span>
                            <span class="books__divine-card-floating-price">{{ $divineBook->price }}</span>
                            <a href="{{ route('books.show', $divineBook->slug) }}" class="books__divine-card-floating-btn">
                                <span>Order Now</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="books__divine-content">
                    <span class="books__divine-eyebrow">Bestseller</span>
                    <h2 class="books__divine-title">Discover Your <span>Divine Identity</span></h2>
                    <p class="books__divine-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="books__divine-testimonials">
                        <div class="books__divine-testimonial">
                            <div class="books__divine-testimonial-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <blockquote class="books__divine-testimonial-text">
                                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."
                            </blockquote>
                            <span class="books__divine-testimonial-author">— Thabo M.</span>
                        </div>
                    </div>
                    <a href="{{ route('books.show', $divineBook->slug) }}" class="books__divine-btn">
                        <span>Read More About This Book</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="books__community">
        <div class="books__community-bg">
            <span class="books__community-tag">COMMUNITY</span>
        </div>

        <div class="wrap">
            <div class="books__community-content">
                <div class="books__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="books__community-title">Join <span>The Collective</span></h2>
                <p class="books__community-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                </p>
                <div class="books__community-benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="books__community-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>Join on WhatsApp</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/books.js') }}"></script>
@endpush

@endsection