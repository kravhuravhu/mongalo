@extends('layouts.app')

@section('title', 'The Collective · Books')

@section('content')

<div class="books-page">

    <!-- ─── HERO ─── -->
    <section class="books-hero">
        <div class="books-hero__shapes">
            <div class="books-hero__shape books-hero__shape--1"></div>
            <div class="books-hero__shape books-hero__shape--2"></div>
            <div class="books-hero__shape books-hero__shape--3"></div>
        </div>

        <div class="books-hero__tag">BOOKS</div>

        <div class="wrap">
            <div class="books-hero__grid">
                <div class="books-hero__content">
                    <span class="section__eyebrow">My Books</span>
                    <h1 class="books-hero__title">
                        Words That <br />
                        <span class="books-hero__title--gradient">Change Everything</span>
                    </h1>
                    <p class="books-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="books-hero__buttons">
                        <a href="#books-grid" class="btn btn--primary">
                            <i class="fas fa-book"></i> Browse Books
                        </a>
                        <a href="#free-resources" class="btn btn--outline">
                            <i class="fas fa-download"></i> Free Resources
                        </a>
                    </div>
                </div>
                <div class="books-hero__image">
                    <div class="books-hero__placeholder">
                        <i class="fas fa-book-open"></i>
                        <span>Explore Our Collection</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── BOOKS GRID ─── -->
    <section class="books-grid" id="books-grid">
        <div class="books-grid__tag">READ</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Available Now</span>
                <h2 class="section__title">My <span>Publications</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="books-grid__filter">
                <button class="books-grid__filter-btn books-grid__filter-btn--active" data-filter="all">All Books</button>
                <button class="books-grid__filter-btn" data-filter="paid">Paid</button>
                <button class="books-grid__filter-btn" data-filter="free">Free Resources</button>
            </div>

            <div class="books-grid__list">
                @forelse($paidBooks as $book)
                <div class="books-grid__card" data-category="paid">
                    <div class="books-grid__cover" style="background:{{ $book->cover_color }};">
                        <span class="books-grid__title">{{ $book->title }}</span>
                        @if($book->is_featured)
                            <span class="books-grid__badge">Featured</span>
                        @endif
                    </div>
                    <div class="books-grid__info">
                        <h4 class="books-grid__name">{{ $book->title }}</h4>
                        <p class="books-grid__desc">{{ $book->subtitle ?? Str::limit($book->description, 80) }}</p>
                        <div class="books-grid__meta">
                            <span class="books-grid__price">{{ $book->price }}</span>
                            <span class="books-grid__type">Physical + Digital</span>
                        </div>
                        <div class="books-grid__actions">
                            <a href="{{ route('books.show', $book->slug) }}" class="btn btn--primary btn--sm">View Details</a>
                            <a href="#" class="btn btn--outline btn--sm">Preview</a>
                        </div>
                    </div>
                </div>
                @empty
                <p class="books-grid__empty">No books available yet. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── FREE RESOURCES ─── -->
    <section class="free-resources" id="free-resources">
        <div class="free-resources__tag">FREE</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">No Catch</span>
                <h2 class="section__title">Free <span>Resources</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="free-resources__grid">
                @forelse($freeBooks as $resource)
                <div class="free-resources__item">
                    <div class="free-resources__icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="free-resources__name">{{ $resource->title }}</div>
                    <div class="free-resources__sub">{{ $resource->subtitle ?? 'Free Download' }}</div>
                    <div class="free-resources__desc">{{ Str::limit($resource->description, 80) }}</div>
                    <a href="#" class="free-resources__btn">
                        <i class="fas fa-download"></i> Download Now
                    </a>
                </div>
                @empty
                <p class="free-resources__empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── QUOTES ─── -->
    <section class="books-quotes">
        <div class="books-quotes__tag">GROWTH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Words That Inspire</span>
                <h2 class="section__title">What Readers Are <span>Saying</span></h2>
            </div>

            <div class="books-quotes__grid">
                <div class="books-quotes__item">
                    <div class="books-quotes__stars">★★★★★</div>
                    <blockquote class="books-quotes__text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."</blockquote>
                    <div class="books-quotes__author">
                        <span class="books-quotes__name">— Thabo M.</span>
                        <span class="books-quotes__location">Johannesburg</span>
                    </div>
                </div>

                <div class="books-quotes__item">
                    <div class="books-quotes__stars">★★★★★</div>
                    <blockquote class="books-quotes__text">"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat."</blockquote>
                    <div class="books-quotes__author">
                        <span class="books-quotes__name">— Nomsa K.</span>
                        <span class="books-quotes__location">Pretoria</span>
                    </div>
                </div>

                <div class="books-quotes__item">
                    <div class="books-quotes__stars">★★★★★</div>
                    <blockquote class="books-quotes__text">"Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt."</blockquote>
                    <div class="books-quotes__author">
                        <span class="books-quotes__name">— Sipho Z.</span>
                        <span class="books-quotes__location">Soweto</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="books-community">
        <div class="wrap">
            <div class="books-community__content">
                <div class="books-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="books-community__title">Join <span>The Collective</span></h2>
                <p class="books-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="books-community__benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection