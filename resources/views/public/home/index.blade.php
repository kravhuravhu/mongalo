@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Faith · Salvation · Baptism · Growth')

@section('content')

<div class="home">

    <!-- HERO -->
    <section class="home__hero">
        <div class="home__hero-bg">
            <div class="home__hero-orb home__hero-orb--1"></div>
            <div class="home__hero-orb home__hero-orb--2"></div>
            <div class="home__hero-orb home__hero-orb--3"></div>
        </div>

        <div class="wrap">
            <div class="home__hero-grid">
                <div class="home__hero-content">
                    <span class="home__hero-badge">A Community of Faith · Growth · Purpose</span>
                    <h1 class="home__hero-title">
                        Welcome to<br />
                        <span class="home__hero-gradient">{{ env('PROJECT_NAME', 'The Collective') }}</span>
                    </h1>
                    <p class="home__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="home__hero-actions">
                        <a href="{{ route('books.index') }}" class="btn btn--primary">Explore Books</a>
                        <a href="{{ route('events.index') }}" class="btn btn--outline">Upcoming Events</a>
                    </div>
                    <div class="home__hero-trust">
                        <div class="home__hero-avatars">
                            <span class="home__hero-avatar">NM</span>
                            <span class="home__hero-avatar">TK</span>
                            <span class="home__hero-avatar">ZD</span>
                            <span class="home__hero-avatar">PM</span>
                            <span class="home__hero-avatar home__hero-avatar--count">+243</span>
                        </div>
                        <div class="home__hero-trust-text">
                            <strong>247+ believers</strong>
                            already in our WhatsApp community
                        </div>
                    </div>
                </div>

                <div class="home__hero-visual">
                    <div class="home__hero-book">
                        <div class="home__hero-book-inner">
                            <div class="home__hero-book-cover">
                                <div class="home__hero-book-title">Divine Identity</div>
                                <div class="home__hero-book-divider"></div>
                                <div class="home__hero-book-author">Arthur Mongalo</div>
                            </div>
                        </div>
                        <div class="home__hero-book-badge">Now Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS BANNER -->
    <section class="home__stats">
        <div class="wrap">
            <div class="home__stats-grid">
                <div class="home__stats-item">
                    <span class="home__stats-number">247+</span>
                    <span class="home__stats-label">Community Members</span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number">4</span>
                    <span class="home__stats-label">Books Published</span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number">12+</span>
                    <span class="home__stats-label">Events Hosted</span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number">3</span>
                    <span class="home__stats-label">Cities Reached</span>
                </div>
            </div>
        </div>
    </section>

    <!-- FOUR PILLARS -->
    <section class="home__pillars">
        <div class="home__pillars-tag">FAITH</div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Our Foundation</span>
                <h2 class="section-header__title">Four Pillars of <span>Faith</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="home__pillars-grid">
                <div class="home__pillars-card home__pillars-card--1">
                    <span class="home__pillars-num">I</span>
                    <div class="home__pillars-icon"><i class="fas fa-cross"></i></div>
                    <h3 class="home__pillars-name">Faith</h3>
                    <p class="home__pillars-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--2">
                    <span class="home__pillars-num">II</span>
                    <div class="home__pillars-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="home__pillars-name">Salvation</h3>
                    <p class="home__pillars-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--3">
                    <span class="home__pillars-num">III</span>
                    <div class="home__pillars-icon"><i class="fas fa-water"></i></div>
                    <h3 class="home__pillars-name">Baptism</h3>
                    <p class="home__pillars-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <a href="{{ route('baptism') }}" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--4">
                    <span class="home__pillars-num">IV</span>
                    <div class="home__pillars-icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="home__pillars-name">Growth</h3>
                    <p class="home__pillars-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURED BOOK -->
    @if($featuredBook)
    <section class="home__featured">
        <div class="home__featured-tag">BOOKS</div>
        
        <!-- Decorative shapes -->
        <div class="home__featured-shape home__featured-shape--1"></div>
        <div class="home__featured-shape home__featured-shape--2"></div>

        <div class="wrap">
            <div class="home__featured-grid">
                <div class="home__featured-content">
                    <span class="section-header__eyebrow">Featured Book</span>
                    <h2 class="home__featured-title">{{ $featuredBook->title }}</h2>
                    <p class="home__featured-subtitle">{{ $featuredBook->subtitle }}</p>
                    <p class="home__featured-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="home__featured-meta">
                        <span class="home__featured-price">{{ $featuredBook->price }}</span>
                        <span class="home__featured-badge">Bestseller</span>
                    </div>
                    <a href="{{ route('books.show', $featuredBook->slug) }}" class="btn btn--primary">
                        <i class="fas fa-book-open"></i> Read More
                    </a>
                </div>
                <div class="home__featured-cover">
                    <div class="home__featured-placeholder" style="background:{{ $featuredBook->cover_color }};">
                        {{ $featuredBook->title }}
                        <small>Arthur Mongalo</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- BOOKS GRID -->
    <section class="home__books">
        <div class="home__books-tag">READ</div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">My Books</span>
                <h2 class="section-header__title">Words That <span>Change Everything</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="home__books-grid">
                @forelse($books as $book)
                <div class="home__books-card">
                    <div class="home__books-cover" style="background:{{ $book->cover_color }};">
                        <span class="home__books-title">{{ $book->title }}</span>
                        @if($book->is_featured)
                            <span class="home__books-badge">Featured</span>
                        @endif
                    </div>
                    <div class="home__books-info">
                        <h4 class="home__books-name">{{ $book->title }}</h4>
                        <p class="home__books-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="home__books-meta">
                            <span class="home__books-price">{{ $book->price }}</span>
                        </div>
                        <a href="{{ route('books.show', $book->slug) }}" class="btn btn--primary btn--sm">View Details</a>
                    </div>
                </div>
                @empty
                <p class="home__books-empty">No books available yet. Check back soon!</p>
                @endforelse
            </div>

            <div class="home__books-footer">
                <a href="{{ route('books.index') }}" class="btn btn--outline">View All Books <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- FREE RESOURCES -->
    <section class="home__resources">
        <div class="home__resources-tag">FREE</div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Free Resources</span>
                <h2 class="section-header__title">Tools to Help You <span>Grow</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="home__resources-grid">
                @forelse($freeResources as $resource)
                <div class="home__resources-item">
                    <div class="home__resources-icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="home__resources-name">{{ $resource->title }}</div>
                    <div class="home__resources-sub">{{ $resource->subtitle ?? 'Free Download' }}</div>
                    <div class="home__resources-label"><i class="fas fa-download"></i> Free Download</div>
                </div>
                @empty
                <p class="home__resources-empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- EVENTS -->
    <section class="home__events">
        <div class="home__events-tag">EVENTS</div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Upcoming Events</span>
                <h2 class="section-header__title">Come &amp; <span>Experience It</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="home__events-list">
                @forelse($upcomingEvents as $index => $event)
                <div class="home__events-card home__events-card--{{ $index % 2 === 0 ? 'left' : 'right' }}">
                    <div class="home__events-date">
                        <span class="home__events-day">{{ $event->date->format('d') }}</span>
                        <span class="home__events-month">{{ $event->date->format('M') }}</span>
                        <span class="home__events-year">{{ $event->date->format('Y') }}</span>
                    </div>
                    <div class="home__events-info">
                        <span class="home__events-type">
                            @if(str_contains($event->title, 'Conference')) Conference
                            @elseif(str_contains($event->title, 'Revival')) Revival
                            @elseif(str_contains($event->title, 'Gathering')) Gathering
                            @else Event
                            @endif
                        </span>
                        <h4 class="home__events-name">{{ $event->title }}</h4>
                        <p class="home__events-location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        <p class="home__events-time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                    </div>
                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn--primary btn--sm">Register</a>
                </div>
                @empty
                <p class="home__events-empty">No upcoming events. Check back soon!</p>
                @endforelse
            </div>

            <div class="home__events-footer">
                <a href="{{ route('events.index') }}" class="btn btn--outline">View All Events <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- BAPTISM CTA -->
    <section class="home__baptism">
        <div class="home__baptism-bg">
            <div class="home__baptism-wave home__baptism-wave--1"></div>
            <div class="home__baptism-wave home__baptism-wave--2"></div>
            <div class="home__baptism-wave home__baptism-wave--3"></div>
        </div>
        
        <!-- Water droplets -->
        <div class="home__baptism-droplet home__baptism-droplet--1"></div>
        <div class="home__baptism-droplet home__baptism-droplet--2"></div>
        <div class="home__baptism-droplet home__baptism-droplet--3"></div>
        <div class="home__baptism-droplet home__baptism-droplet--4"></div>
        
        <div class="home__baptism-tag">BAPTISM</div>

        <div class="wrap">
            <div class="home__baptism-content">
                <div class="home__baptism-icon"><i class="fas fa-water"></i></div>
                <h2 class="home__baptism-title">Ready to be <span>Baptized?</span></h2>
                <p class="home__baptism-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <a href="{{ route('baptism') }}" class="btn btn--primary btn--lg">
                    <i class="fas fa-water"></i> Let's Talk About Baptism
                </a>
                <div class="home__baptism-features">
                    <span><i class="fas fa-check-circle"></i> One-on-one conversation</span>
                    <span><i class="fas fa-check-circle"></i> No pressure</span>
                    <span><i class="fas fa-check-circle"></i> Anywhere in Gauteng</span>
                </div>
            </div>
        </div>
    </section>

    <!-- QUOTES -->
    <section class="home__quotes">
        <div class="home__quotes-tag">COMMUNITY</div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Scripture That Speaks</span>
                <h2 class="section-header__title">Words That <span>Shaped Us</span></h2>
            </div>

            <div class="home__quotes-grid">
                <div class="home__quotes-item">
                    <span class="home__quotes-num">I</span>
                    <div>
                        <blockquote>"For we walk by faith, not by sight."</blockquote>
                        <span class="home__quotes-ref">2 Corinthians 5:7</span>
                    </div>
                </div>
                <div class="home__quotes-item">
                    <span class="home__quotes-num">II</span>
                    <div>
                        <blockquote>"If you confess with your mouth the Lord Jesus and believe in your heart that God has raised Him from the dead, you will be saved."</blockquote>
                        <span class="home__quotes-ref">Romans 10:9</span>
                    </div>
                </div>
                <div class="home__quotes-item">
                    <span class="home__quotes-num">III</span>
                    <div>
                        <blockquote>"Therefore we were buried with Him through baptism into death, that just as Christ was raised from the dead by the glory of the Father, even so we also should walk in newness of life."</blockquote>
                        <span class="home__quotes-ref">Romans 6:4</span>
                    </div>
                </div>
                <div class="home__quotes-item">
                    <span class="home__quotes-num">IV</span>
                    <div>
                        <blockquote>"But grow in the grace and knowledge of our Lord and Savior Jesus Christ."</blockquote>
                        <span class="home__quotes-ref">2 Peter 3:18</span>
                    </div>
                </div>
                <div class="home__quotes-item">
                    <span class="home__quotes-num">V</span>
                    <div>
                        <blockquote>"I can do all things through Christ who strengthens me."</blockquote>
                        <span class="home__quotes-ref">Philippians 4:13</span>
                    </div>
                </div>
                <div class="home__quotes-item">
                    <span class="home__quotes-num">VI</span>
                    <div>
                        <blockquote>"For God so loved the world that He gave His only begotten Son, that whoever believes in Him should not perish but have everlasting life."</blockquote>
                        <span class="home__quotes-ref">John 3:16</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- COMMUNITY CTA -->
    <section class="home__community">
        <div class="wrap">
            <div class="home__community-content">
                <div class="home__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="home__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="home__community-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="home__community-benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/home.js') }}"></script>
@endpush

@endsection