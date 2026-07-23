@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Books & Resources')

@section('content')

@php
    // Divine Identity
    $divineBook = $paidBooks->first(function($book) {
        return str_contains(strtolower($book->title), 'divine') || str_contains(strtolower($book->title), 'identity');
    }) ?? $paidBooks->first();
@endphp

<div class="books">

    {{-- BOOKS FLOATING ORBS --}}
    <div class="books__orbs">
        <div class="books__orb books__orb--1"></div>
        <div class="books__orb books__orb--2"></div>
        <div class="books__orb books__orb--3"></div>
        <div class="books__orb books__orb--4"></div>
        <div class="books__orb books__orb--5"></div>
    </div>

    {{-- HERO --}}
    <section class="books__hero">
        <div class="books__hero-bg">
            <div class="books__hero-pattern"></div>
            <div class="books__hero-shape books__hero-shape--1"></div>
            <div class="books__hero-shape books__hero-shape--2"></div>
            <div class="books__hero-shape books__hero-shape--3"></div>
            <div class="books__hero-particle books__hero-particle--1"></div>
            <div class="books__hero-particle books__hero-particle--2"></div>
            <div class="books__hero-particle books__hero-particle--3"></div>
            <div class="books__hero-particle books__hero-particle--4"></div>
            <div class="books__hero-particle books__hero-particle--5"></div>
        </div>
        <div class="books__hero-tag">BOOKS</div>

        <div class="wrap">
            <div class="books__hero-grid">
                <div class="books__hero-content">
                    <span class="books__hero-badge">
                        <i class="fas fa-book-open"></i> Library
                    </span>
                    <h1 class="books__hero-title">
                        Explore the <br />
                        <span class="books__hero-gradient">Collection</span>
                    </h1>
                    <p class="books__hero-text">Christian literature to help you understand your identity, grow in faith and walk in freedom. Buy a book or download a free resource, every item exists to serve your journey.</p>

                    <div class="books__hero-search">
                        <div class="books__hero-search-wrapper">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search for a book or resource..." class="books__hero-search-input">
                            <button class="books__hero-search-btn">Search</button>
                        </div>
                    </div>

                    <div class="books__hero-stats">
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $paidBooks->count() + $freeBooks->count() }}</span>
                            <span class="books__hero-stat-label">Total Items</span>
                        </div>
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $paidBooks->count() }}</span>
                            <span class="books__hero-stat-label">Books</span>
                        </div>
                        <div class="books__hero-stat">
                            <span class="books__hero-stat-number">{{ $freeBooks->count() }}</span>
                            <span class="books__hero-stat-label">Free Resources</span>
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

    {{-- CATEGORY FILTERS --}}
    <section class="books__filters">
        <div class="wrap">
            <div class="books__filters-list">
                <button class="books__filters-pill books__filters-pill--active" data-filter="all">All</button>
                <button class="books__filters-pill" data-filter="paid">Books</button>
                <button class="books__filters-pill" data-filter="free">Free Resources</button>
                <button class="books__filters-pill" data-filter="featured">Featured</button>
            </div>
        </div>
    </section>

    {{-- BOOKS GRID --}}
    <section class="books__grid" id="books-grid">
        <div class="books__grid-bg">
            <div class="books__grid-shape books__grid-shape--1"></div>
            <div class="books__grid-shape books__grid-shape--2"></div>
        </div>
        <div class="books__grid-tag">READ</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Collection</span>
                <h2 class="section-header__title">All <span>Books &amp; Resources</span></h2>
                <p class="section-header__subtitle">From paid publications to free downloads, find the resource that fits where you are right now.</p>
            </div>

            <div class="books__grid-masonry">
                @forelse($paidBooks as $index => $book)
                    <div class="books__grid-item books__grid-item--paid" data-category="paid" style="animation-delay: {{ $index * 0.06 }}s;">
                        <div class="books__grid-card books__grid-card--paid">
                            <div class="books__grid-cover" style="background:{{ $book->cover_color ?? '#a67c4e' }};">
                                <span class="books__grid-cover-title">{{ $book->title }}</span>
                                @if($book->is_featured)
                                    <span class="books__grid-cover-badge">★ Featured</span>
                                @endif
                                <div class="books__grid-cover-shine"></div>
                            </div>
                            <div class="books__grid-info">
                                <h4 class="books__grid-name">{{ $book->title }}</h4>
                                <p class="books__grid-desc">{{ Str::limit($book->description, 90) }}</p>
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
                    <p class="books__grid-empty">No books available yet.</p>
                @endforelse

                @forelse($freeBooks as $index => $resource)
                    <div class="books__grid-item books__grid-item--free" data-category="free" style="animation-delay: {{ ($paidBooks->count() + $index) * 0.06 }}s;">
                        <div class="books__grid-card books__grid-card--free">
                            <div class="books__grid-cover" style="background:{{ $resource->cover_color ?? '#4A9E9E' }};">
                                <span class="books__grid-cover-title">{{ $resource->title }}</span>
                                <span class="books__grid-cover-badge books__grid-cover-badge--free">Free</span>
                                <div class="books__grid-cover-shine"></div>
                            </div>
                            <div class="books__grid-info">
                                <h4 class="books__grid-name">{{ $resource->title }}</h4>
                                <p class="books__grid-desc">{{ $resource->subtitle ?? 'Free Download' }}</p>
                                <div class="books__grid-footer">
                                    <span class="books__grid-price books__grid-price--free">Free</span>
                                    <a href="#" class="books__grid-btn books__grid-btn--free">
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

    {{-- FEATURED AUTHOR --}}
    <section class="books__author">
        <div class="books__author-bg">
            <div class="books__author-shape books__author-shape--1"></div>
            <div class="books__author-shape books__author-shape--2"></div>
        </div>
        <div class="books__author-tag">AUTHOR</div>
        <div class="wrap">
            <div class="books__author-grid">
                <div class="books__author-content">
                    <span class="books__author-eyebrow">Meet the Author</span>
                    <h2 class="books__author-title">Arthur <span>Mongalo</span></h2>
                    <p class="books__author-text">Arthur Mongalo is an ICT specialist, project manager and pioneering leader with a deep passion for teaching and empowering others. His writing is inspired by a heartfelt desire to see every child of God maximise their potential and experience the fullness of the Holy Spirit.</p>
                    <p class="books__author-text">He is the founder and former pastor of Christ Tabernacle, where he now focuses on establishing a training institute and spiritual retreat committed to sound doctrine and the fullness of the Holy Spirit. He resides in Gauteng with his family.</p>
                    <div class="books__author-quote">
                        <i class="fas fa-quote-left"></i>
                        <blockquote>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."</blockquote>
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

    {{-- DIVINE IDENTITY SPOTLIGHT --}}
    @if($divineBook)
        <section class="books__spotlight">
            <div class="books__spotlight-bg">
                <div class="books__spotlight-shape books__spotlight-shape--1"></div>
                <div class="books__spotlight-shape books__spotlight-shape--2"></div>
                <div class="books__spotlight-shape books__spotlight-shape--3"></div>
            </div>
            <div class="books__spotlight-tag">SPOTLIGHT</div>

            <div class="wrap">
                <div class="books__spotlight-grid">
                    <div class="books__spotlight-cover">
                        <div class="books__spotlight-book" style="background:{{ $divineBook->cover_color ?? '#8B5E3C' }};">
                            <span class="books__spotlight-book-title">{{ $divineBook->title }}</span>
                            <div class="books__spotlight-book-divider"></div>
                            <span class="books__spotlight-book-author">Arthur Mongalo</span>
                        </div>
                    </div>

                    <div class="books__spotlight-content">
                        <span class="books__spotlight-eyebrow">Bestseller</span>
                        <h2 class="books__spotlight-title">Discover Your <span>Divine Identity</span></h2>
                        <p class="books__spotlight-text">An invitation to encounter the living God in profound and life-changing ways. Divine Identity explores the supernatural dimensions of faith, the transformative power of divine encounters and the boundless love of God, drawing you closer to walking in the extraordinary life He has designed for you.</p>

                        <div class="books__spotlight-testimonial">
                            <div class="books__spotlight-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                            <blockquote class="books__spotlight-testimonial-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."</blockquote>
                            <span class="books__spotlight-testimonial-author">— Thabo M.</span>
                        </div>

                        <div class="books__spotlight-actions">
                            <a href="{{ route('books.show', $divineBook->slug) }}" class="books__spotlight-btn">
                                <span>Read More</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                            <span class="books__spotlight-price">{{ $divineBook->price }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- COMMUNITY CTA --}}
    <section class="books__community">
        <div class="books__community-bg">
            <div class="books__community-shape books__community-shape--1"></div>
            <div class="books__community-shape books__community-shape--2"></div>
            <div class="books__community-shape books__community-shape--3"></div>
        </div>
        <div class="wrap">
            <div class="books__community-content">
                <div class="books__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="books__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="books__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="books__community-btn">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/books.js') }}"></script>
@endpush

@endsection