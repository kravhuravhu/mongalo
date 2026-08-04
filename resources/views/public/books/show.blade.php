@extends('layouts.app')

@section('title', $book->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="book-detail">

    {{-- BOOK DETAIL FLOATING ORBS --}}
    <div class="book-detail__orbs">
        <div class="book-detail__orb book-detail__orb--1"></div>
        <div class="book-detail__orb book-detail__orb--2"></div>
        <div class="book-detail__orb book-detail__orb--3"></div>
        <div class="book-detail__orb book-detail__orb--4"></div>
        <div class="book-detail__orb book-detail__orb--5"></div>
    </div>

    {{-- HERO — Book Detail --}}
    <section class="book-detail__hero">
        <div class="book-detail__hero-bg">
            <div class="book-detail__hero-shape book-detail__hero-shape--1"></div>
            <div class="book-detail__hero-shape book-detail__hero-shape--2"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--1"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--2"></div>
            <div class="book-detail__hero-particle book-detail__hero-particle--3"></div>
        </div>
        <div class="book-detail__hero-tag">BOOK</div>

        <div class="wrap">
            <div class="book-detail__hero-grid">
                {{-- LEFT: Book Cover --}}
                <div class="book-detail__hero-cover">
                    @if($book->cover_image)
                        <div class="book-detail__hero-placeholder {{ $book->cover_image ? 'book-detail__hero-placeholder--with-image' : '' }}" style="background:{{ $book->cover_color ?? '#2d2d44' }}; position: relative; overflow: hidden;">
                            @if($book->cover_image)
                                <img src="{{ asset('storage/books/covers/' . $book->cover_image) }}" 
                                    alt="{{ $book->title }}" 
                                    style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                            @endif
                            <span class="book-detail__hero-placeholder-title" style="position: relative; z-index: 2;">
                                {{ $book->title }}
                            </span>
                            <small class="book-detail__hero-placeholder-author" style="position: relative; z-index: 2;">Arthur Mongalo</small>
                            <div class="book-detail__hero-placeholder-shine"></div>
                        </div>
                    @else
                        <div class="book-detail__hero-placeholder" style="background:{{ $book->cover_color ?? '#2d2d44' }};">
                            <span class="book-detail__hero-placeholder-title">{{ $book->title }}</span>
                            <small class="book-detail__hero-placeholder-author">Arthur Mongalo</small>
                            <div class="book-detail__hero-placeholder-shine"></div>
                        </div>
                    @endif
                </div>

                {{-- RIGHT: Book Info --}}
                <div class="book-detail__hero-content">
                    <span class="book-detail__hero-badge">
                        <i class="fas fa-book"></i> 
                        @if($book->is_free)
                            Free Resource
                        @else
                            Book
                        @endif
                    </span>
                    <h1 class="book-detail__hero-title">{{ $book->title }}</h1>
                    @if($book->subtitle)
                        <p class="book-detail__hero-subtitle">{{ $book->subtitle }}</p>
                    @endif

                    <div class="book-detail__hero-meta">
                        <span class="book-detail__hero-price">{{ $book->formatted_price }}</span>
                        @if($book->is_featured)
                            <span class="book-detail__hero-badge--featured">★ Bestseller</span>
                        @endif
                        @if($book->is_free)
                            <span class="book-detail__hero-badge--free">Free Download</span>
                        @endif
                        @if($book->book_file)
                            <span class="book-detail__hero-badge--featured" style="background: #d4edda; color: #155724; border-color: #b7dfb9;">
                                <i class="fas fa-file-{{ $book->file_type }}"></i> 
                                {{ strtoupper($book->file_type) }} · {{ $book->file_size ?? 'Available' }}
                            </span>
                        @endif
                    </div>

                    <p class="book-detail__hero-text">{{ $book->description }}</p>

                    <div class="book-detail__hero-actions">
                        @if($book->is_free && $book->book_file)
                            {{-- ─── FREE DOWNLOAD ─── --}}
                            <a href="#" class="btn btn--primary btn--lg" onclick="event.preventDefault(); alert('Free download will be available here.');">
                                <i class="fas fa-download"></i> Download Free
                            </a>
                        @elseif($book->book_file)
                            {{-- ─── PAID BOOK ─── --}}
                            <a href="#" class="btn btn--primary btn--lg" onclick="event.preventDefault(); alert('Payment integration coming soon. Please check back later.');">
                                <i class="fas fa-shopping-cart"></i> Buy Now
                            </a>
                            <a href="#" class="btn btn--outline" onclick="event.preventDefault(); alert('Preview coming soon.');">
                                <i class="fas fa-book-open"></i> Preview
                            </a>
                        @else
                            {{-- ─── NO FILE UPLOADED ─── --}}
                            <div class="book-detail__hero-notice" style="background: #fff3cd; color: #856404; padding: 12px 20px; border-radius: 10px; font-size: 0.85rem;">
                                <i class="fas fa-info-circle"></i> 
                                This book will be available soon. Check back later.
                            </div>
                        @endif
                    </div>

                    <div class="book-detail__hero-features">
                        @if($book->book_file)
                            <span><i class="fas fa-check-circle"></i> Instant Download</span>
                            <span><i class="fas fa-check-circle"></i> Secure Access</span>
                            @if(!$book->is_free)
                                <span><i class="fas fa-check-circle"></i> One-time Purchase</span>
                            @endif
                        @endif
                        <span><i class="fas fa-check-circle"></i> Read on Any Device</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- RELATED BOOKS --}}
    @if($relatedBooks->count() > 0)
        <section class="book-detail__related">
            <div class="book-detail__related-bg">
                <div class="book-detail__related-shape book-detail__related-shape--1"></div>
                <div class="book-detail__related-shape book-detail__related-shape--2"></div>
            </div>
            <div class="book-detail__related-tag">RELATED</div>
            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">You Might Also Like</span>
                    <h2 class="section-header__title">Related <span>Books</span></h2>
                </div>

                <div class="book-detail__related-grid">
                    @foreach($relatedBooks as $related)
                        <div class="book-detail__related-card reveal reveal--scale" data-delay="{{ $loop->index * 100 }}">
                            <div class="book-detail__related-cover {{ $related->cover_image ? 'book-detail__related-cover--with-image' : '' }}" style="background:{{ $related->cover_color ?? '#a67c4e' }}; position: relative; overflow: hidden;">
                                @if($related->cover_image)
                                    <img src="{{ asset('storage/books/covers/' . $related->cover_image) }}" 
                                        alt="{{ $related->title }}" 
                                        style="width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                                @endif
                                <span class="book-detail__related-cover-title" style="position: relative; z-index: 2;">
                                    {{ $related->title }}
                                </span>
                                <div class="book-detail__related-cover-shine"></div>
                            </div>
                            <div class="book-detail__related-info">
                                <h4 class="book-detail__related-name">{{ $related->title }}</h4>
                                <span class="book-detail__related-price">{{ $related->formatted_price }}</span>
                                <a href="{{ route('books.show', $related->slug) }}" class="btn btn--primary btn--sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- COMMUNITY CTA --}}
    <section class="book-detail__community">
        <div class="book-detail__community-bg">
            <div class="book-detail__community-shape book-detail__community-shape--1"></div>
            <div class="book-detail__community-shape book-detail__community-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="book-detail__community-content reveal" data-delay="100">
                <div class="book-detail__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="book-detail__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="book-detail__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
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