@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Faith · Salvation · Baptism · Growth')

@section('content')

<div class="home">

    <!-- ─── HERO SPECTRUM ─── -->
    <section class="home__hero">
        <div class="home__hero-bg">
            <div class="home__hero-orb home__hero-orb--1"></div>
            <div class="home__hero-orb home__hero-orb--2"></div>
            <div class="home__hero-orb home__hero-orb--3"></div>
            <div class="home__hero-orb home__hero-orb--4"></div>
            <div class="home__hero-grid-pattern"></div>
        </div>

        <div class="home__hero-scroll-indicator">
            <span class="home__hero-scroll-text">Scroll</span>
            <span class="home__hero-scroll-line"></span>
        </div>

        <div class="wrap">
            <div class="home__hero-container">
                <div class="home__hero-content">
                    <div class="home__hero-badge-wrapper">
                        <span class="home__hero-badge">
                            <i class="fas fa-cross" aria-hidden="true"></i>
                            A Community of Faith &amp; Purpose
                        </span>
                    </div>
                    <h1 class="home__hero-title">
                        Welcome to
                        <span class="home__hero-title-highlight">{{ env('PROJECT_NAME', 'The Collective') }}</span>
                    </h1>
                    <p class="home__hero-text">
                        A faith community built on one vision: to baptise at least a million people in water, pray for at least a million people and equip every believer through water baptism, Spirit baptism and the renewal of the mind. Explore our books, download free faith resources and join a growing community of believers walking in purpose.
                    </p>
                    <div class="home__hero-actions">
                        <a href="{{ route('books.index') }}" class="home__hero-btn home__hero-btn--primary">
                            <span>Explore Books</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('events.index') }}" class="home__hero-btn home__hero-btn--secondary">
                            <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                            <span>Upcoming Events</span>
                        </a>
                    </div>
                    <div class="home__hero-trust">
                        <div class="home__hero-avatars">
                            <span class="home__hero-avatar" style="background:#a67c4e;color:#fff;">NM</span>
                            <span class="home__hero-avatar" style="background:#c69a6a;color:#fff;">TK</span>
                            <span class="home__hero-avatar" style="background:#8B5E3C;color:#fff;">ZD</span>
                            <span class="home__hero-avatar" style="background:#a67c4e;color:#fff;">PM</span>
                            <span class="home__hero-avatar home__hero-avatar--count">+243</span>
                        </div>
                        <div class="home__hero-trust-text">
                            <strong>247+ believers</strong>
                            <span>already in our WhatsApp community</span>
                        </div>
                    </div>
                </div>

                <div class="home__hero-visual">
                    <div class="home__hero-floating-card">
                        <div class="home__hero-floating-card-inner">
                            <div class="home__hero-floating-card-cover">
                                <div class="home__hero-floating-card-icon">
                                    <i class="fas fa-book-open" aria-hidden="true"></i>
                                </div>
                                <div class="home__hero-floating-card-title">Divine Identity</div>
                                <div class="home__hero-floating-card-divider"></div>
                                <div class="home__hero-floating-card-author">Arthur Mongalo</div>
                            </div>
                        </div>
                        <div class="home__hero-floating-card-badge">
                            <span>New Release</span>
                            <i class="fas fa-star" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="home__hero-float-icons">
                        <span class="home__hero-float-icon home__hero-float-icon--1">
                            <i class="fas fa-cross"></i>
                        </span>
                        <span class="home__hero-float-icon home__hero-float-icon--2">
                            <i class="fas fa-water"></i>
                        </span>
                        <span class="home__hero-float-icon home__hero-float-icon--3">
                            <i class="fas fa-seedling"></i>
                        </span>
                        <span class="home__hero-float-icon home__hero-float-icon--4">
                            <i class="fas fa-hand-holding-heart"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── STATS BANNER ─── -->
    <section class="home__stats">
        <div class="wrap">
            <div class="home__stats-grid">
                <div class="home__stats-item">
                    <span class="home__stats-number" data-count="247">0</span>
                    <span class="home__stats-label">Community Members</span>
                    <span class="home__stats-icon"><i class="fas fa-users"></i></span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number" data-count="4">0</span>
                    <span class="home__stats-label">Books Published</span>
                    <span class="home__stats-icon"><i class="fas fa-book"></i></span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number" data-count="12">0</span>
                    <span class="home__stats-label">Events Hosted</span>
                    <span class="home__stats-icon"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <div class="home__stats-item">
                    <span class="home__stats-number" data-count="3">0</span>
                    <span class="home__stats-label">Cities Reached</span>
                    <span class="home__stats-icon"><i class="fas fa-map-marker-alt"></i></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FOUR PILLARS ─── -->
    <section class="home__pillars">
        <div class="home__pillars-bg">
            <span class="home__pillars-tag">FAITH</span>
        </div>

        <div class="wrap">
            <div class="home__pillars-header">
                <span class="home__pillars-eyebrow">Our Foundation</span>
                <h2 class="home__pillars-title">Four Pillars of <span>Faith</span></h2>
                <p class="home__pillars-subtitle">
                    Everything we do is built on these four foundations. They shape our mission, our resources and our community.
                </p>
            </div>

            <div class="home__pillars-grid">
                <div class="home__pillars-card home__pillars-card--faith">
                    <div class="home__pillars-card-number">01</div>
                    <div class="home__pillars-card-icon">
                        <i class="fas fa-cross"></i>
                    </div>
                    <h3 class="home__pillars-card-title">Prayer</h3>
                    <p class="home__pillars-card-desc">
                        Prayer is the foundation of everything we do. Through prayer we connect with God, intercede for others and invite His power into every situation. "Pray without ceasing" (1 Thessalonians 5:17). Our goal is to pray for at least a million people.
                    </p>
                    <a href="#" class="home__pillars-card-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="home__pillars-card-shape"></div>
                </div>

                <div class="home__pillars-card home__pillars-card--salvation">
                    <div class="home__pillars-card-number">02</div>
                    <div class="home__pillars-card-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h3 class="home__pillars-card-title">Salvation</h3>
                    <p class="home__pillars-card-desc">
                        Salvation is the starting point of every faith journey. "If you confess with your mouth the Lord Jesus and believe in your heart that God has raised Him from the dead, you will be saved" (Romans 10:9). Free resources like My Salvation Companion are here to guide you through that first step.
                    </p>
                    <a href="#" class="home__pillars-card-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="home__pillars-card-shape"></div>
                </div>

                <div class="home__pillars-card home__pillars-card--baptism">
                    <div class="home__pillars-card-number">03</div>
                    <div class="home__pillars-card-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h3 class="home__pillars-card-title">Baptism</h3>
                    <p class="home__pillars-card-desc">
                        Water baptism is an act of obedience and a public declaration of faith. "Go therefore and make disciples of all the nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit" (Matthew 28:19). We believe in water baptism, Spirit baptism and the renewal of the mind.
                    </p>
                    <a href="{{ route('baptism') }}" class="home__pillars-card-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="home__pillars-card-shape"></div>
                </div>

                <div class="home__pillars-card home__pillars-card--growth">
                    <div class="home__pillars-card-number">04</div>
                    <div class="home__pillars-card-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h3 class="home__pillars-card-title">Growth</h3>
                    <p class="home__pillars-card-desc">
                        Growth does not stop at salvation. "But grow in the grace and knowledge of our Lord and Savior Jesus Christ" (2 Peter 3:18). Through Scripture, community and discipleship we continue to mature in faith. Our books and free resources support that journey every step of the way.
                    </p>
                    <a href="#" class="home__pillars-card-link">
                        <span>Learn More</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="home__pillars-card-shape"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FEATURED BOOK ─── -->
    @if($featuredBook)
    <section class="home__featured">
        <div class="home__featured-bg">
            <span class="home__featured-tag">BOOKS</span>
            <div class="home__featured-shape home__featured-shape--1"></div>
            <div class="home__featured-shape home__featured-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="home__featured-container">
                <div class="home__featured-content">
                    <span class="home__featured-eyebrow">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        Featured Book
                    </span>
                    <h2 class="home__featured-title">{{ $featuredBook->title }}</h2>
                    <p class="home__featured-subtitle">{{ $featuredBook->subtitle }}</p>
                    <p class="home__featured-desc">
                        Divine Identity takes you deeper into understanding your spiritual identity. It dismantles the lies holding you back and equips you to walk boldly in the purpose God has given you. Written by Arthur Mongalo from years of real ministry conversations with believers across South Africa.
                    </p>
                    <div class="home__featured-meta">
                        <span class="home__featured-price">{{ $featuredBook->price }}</span>
                        <span class="home__featured-badge">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Bestseller
                        </span>
                    </div>
                    <div class="home__featured-actions">
                        <a href="{{ route('books.show', $featuredBook->slug) }}" class="home__featured-btn home__featured-btn--primary">
                            <span>Read More</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="home__featured-btn home__featured-btn--secondary">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Order Now</span>
                        </a>
                    </div>
                </div>

                <div class="home__featured-cover-wrapper">
                    <div class="home__featured-cover" style="background:{{ $featuredBook->cover_color ?? '#8B5E3C' }};">
                        <div class="home__featured-cover-inner">
                            <div class="home__featured-cover-title">{{ $featuredBook->title }}</div>
                            <div class="home__featured-cover-divider"></div>
                            <div class="home__featured-cover-author">Arthur Mongalo</div>
                        </div>
                        <div class="home__featured-cover-glow"></div>
                    </div>
                    <div class="home__featured-cover-shadows">
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ─── BOOKS GRID ─── -->
    <section class="home__books">
        <div class="home__books-bg">
            <span class="home__books-tag">READ</span>
        </div>

        <div class="wrap">
            <div class="home__books-header">
                <span class="home__books-eyebrow">My Books</span>
                <h2 class="home__books-title">Words That <span>Change Everything</span></h2>
                <p class="home__books-subtitle">
                    Each book is written to help you understand your identity in Christ, grow in faith and walk in freedom. Whether you buy or download for free, every resource exists to serve your journey.
                </p>
            </div>

            <div class="home__books-grid">
                @forelse($books as $index => $book)
                <div class="home__books-card" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="home__books-cover" style="background:{{ $book->cover_color ?? '#a67c4e' }};">
                        <span class="home__books-cover-title">{{ $book->title }}</span>
                        @if($book->is_featured)
                            <span class="home__books-cover-badge">
                                <i class="fas fa-star"></i>
                                Featured
                            </span>
                        @endif
                        <div class="home__books-cover-shine"></div>
                    </div>
                    <div class="home__books-info">
                        <h4 class="home__books-name">{{ $book->title }}</h4>
                        <p class="home__books-desc">
                            <p class="home__books-desc">{{ Str::limit($book->description, 120) }}</p>
                        </p>
                        <div class="home__books-meta">
                            <span class="home__books-price">{{ $book->price }}</span>
                            <span class="home__books-type">
                                <i class="fas fa-book"></i>
                                Book
                            </span>
                        </div>
                        <a href="{{ route('books.show', $book->slug) }}" class="home__books-btn">
                            <span>View Details</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="home__books-empty">No books available yet. Check back soon!</p>
                @endforelse
            </div>

            <div class="home__books-footer">
                <a href="{{ route('books.index') }}" class="home__books-view-all">
                    <span>View All Books</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ─── FREE RESOURCES ─── -->
    <section class="home__resources">
        <div class="home__resources-bg">
            <span class="home__resources-tag">FREE</span>
        </div>

        <div class="wrap">
            <div class="home__resources-header">
                <span class="home__resources-eyebrow">Free Resources</span>
                <h2 class="home__resources-title">Tools to Help You <span>Grow</span></h2>
                <p class="home__resources-subtitle">
                    Free Christian literature, Bibles, pamphlets and ministry materials to support your faith journey. Resources from partners like Gideon South Africa and Chick Publications are also available. Download digital copies or contact us for physical materials. Groups and organisations can arrange bulk delivery of Bibles and other free resources directly.
                </p>
            </div>

            <div class="home__resources-grid">
                @forelse($freeResources as $index => $resource)
                <div class="home__resources-item" style="animation-delay: {{ $index * 0.08 }}s;">
                    <div class="home__resources-icon-wrapper">
                        <i class="fas fa-file-pdf"></i>
                    </div>
                    <h4 class="home__resources-name">{{ $resource->title }}</h4>
                    <p class="home__resources-sub">{{ $resource->subtitle ?? 'Free Download' }}</p>
                    <a href="#" class="home__resources-download">
                        <i class="fas fa-download"></i>
                        <span>Download Now</span>
                    </a>
                </div>
                @empty
                <p class="home__resources-empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── EVENTS TIMELINE ─── -->
    <section class="home__events">
        <div class="home__events-bg">
            <span class="home__events-tag">EVENTS</span>
            <div class="home__events-line"></div>
        </div>

        <div class="wrap">
            <div class="home__events-header">
                <span class="home__events-eyebrow">Upcoming Events</span>
                <h2 class="home__events-title">Come &amp; <span>Experience It</span></h2>
                <p class="home__events-subtitle">
                    Join us for conferences, revival nights and community gatherings. Every event is an opportunity to worship, learn and connect with other believers.
                </p>
            </div>

            <div class="home__events-list">
                @forelse($upcomingEvents as $index => $event)
                <div class="home__events-card" style="animation-delay: {{ $index * 0.15 }}s;">
                    <div class="home__events-card-line"></div>
                    <div class="home__events-card-dot"></div>
                    <div class="home__events-date">
                        <span class="home__events-day">{{ $event->date->format('d') }}</span>
                        <span class="home__events-month">{{ $event->date->format('M') }}</span>
                        <span class="home__events-year">{{ $event->date->format('Y') }}</span>
                    </div>
                    <div class="home__events-info">
                        <span class="home__events-type">
                            @if(str_contains($event->title, 'Conference'))
                                <i class="fas fa-users"></i> Conference
                            @elseif(str_contains($event->title, 'Revival'))
                                <i class="fas fa-fire"></i> Revival
                            @elseif(str_contains($event->title, 'Gathering'))
                                <i class="fas fa-handshake"></i> Gathering
                            @else
                                <i class="fas fa-calendar-alt"></i> Event
                            @endif
                        </span>
                        <h4 class="home__events-name">{{ $event->title }}</h4>
                        <div class="home__events-meta">
                            <span class="home__events-location">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $event->location }}
                            </span>
                            <span class="home__events-time">
                                <i class="fas fa-clock"></i>
                                {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                            </span>
                        </div>
                        <a href="{{ route('events.show', $event->slug) }}" class="home__events-btn">
                            <span>Register Now</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <p class="home__events-empty">No upcoming events. Check back soon!</p>
                @endforelse
            </div>

            <div class="home__events-footer">
                <a href="{{ route('events.index') }}" class="home__events-view-all">
                    <span>View All Events</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- ─── BAPTISM CTA ─── -->
    <section class="home__baptism">
        <div class="home__baptism-bg">
            <div class="home__baptism-wave home__baptism-wave--1"></div>
            <div class="home__baptism-wave home__baptism-wave--2"></div>
            <div class="home__baptism-wave home__baptism-wave--3"></div>
        </div>
        <div class="home__baptism-droplets">
            <span class="home__baptism-droplet home__baptism-droplet--1"></span>
            <span class="home__baptism-droplet home__baptism-droplet--2"></span>
            <span class="home__baptism-droplet home__baptism-droplet--3"></span>
            <span class="home__baptism-droplet home__baptism-droplet--4"></span>
            <span class="home__baptism-droplet home__baptism-droplet--5"></span>
        </div>
        <div class="home__baptism-tag">BAPTISM</div>

        <div class="wrap">
            <div class="home__baptism-content">
                <div class="home__baptism-icon">
                    <i class="fas fa-water"></i>
                </div>
                <h2 class="home__baptism-title">Ready to be <span>Baptized?</span></h2>
                <p class="home__baptism-desc">
                    "Repent, and let every one of you be baptized in the name of Jesus Christ for the remission of sins; and you shall receive the gift of the Holy Spirit" (Acts 2:38). Whether you are considering baptism for the first time or want to understand what water baptism and Spirit baptism mean, we would love to have that conversation with you. No pressure, just an honest talk about faith and obedience.
                </p>
                <div class="home__baptism-steps">
                    <div class="home__baptism-step">
                        <span class="home__baptism-step-number">1</span>
                        <span class="home__baptism-step-text">Let's Talk</span>
                    </div>
                    <div class="home__baptism-step">
                        <span class="home__baptism-step-number">2</span>
                        <span class="home__baptism-step-text">Prepare</span>
                    </div>
                    <div class="home__baptism-step">
                        <span class="home__baptism-step-number">3</span>
                        <span class="home__baptism-step-text">Celebrate</span>
                    </div>
                </div>
                <a href="{{ route('baptism') }}" class="home__baptism-btn">
                    <i class="fas fa-water"></i>
                    <span>Let's Talk About Baptism</span>
                </a>
                <div class="home__baptism-features">
                    <span>
                        <i class="fas fa-check-circle"></i>
                        One-on-one conversation
                    </span>
                    <span>
                        <i class="fas fa-check-circle"></i>
                        No pressure
                    </span>
                    <span>
                        <i class="fas fa-check-circle"></i>
                        Anywhere in Gauteng
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── SCRIPTURE QUOTES ─── -->
    <section class="home__quotes">
        <div class="home__quotes-bg">
            <span class="home__quotes-tag">SCRIPTURE</span>
        </div>

        <div class="wrap">
            <div class="home__quotes-header">
                <span class="home__quotes-eyebrow">Scripture That Speaks</span>
                <h2 class="home__quotes-title">Words That <span>Shaped Us</span></h2>
            </div>

            <div class="home__quotes-grid">
                <div class="home__quotes-item" style="animation-delay: 0.05s;">
                    <div class="home__quotes-number">I</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "For we walk by faith, not by sight."
                        </blockquote>
                        <cite>2 Corinthians 5:7</cite>
                    </div>
                </div>

                <div class="home__quotes-item" style="animation-delay: 0.1s;">
                    <div class="home__quotes-number">II</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "If you confess with your mouth the Lord Jesus and believe in your heart that God has raised Him from the dead, you will be saved."
                        </blockquote>
                        <cite>Romans 10:9</cite>
                    </div>
                </div>

                <div class="home__quotes-item" style="animation-delay: 0.15s;">
                    <div class="home__quotes-number">III</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "Therefore we were buried with Him through baptism into death, that just as Christ was raised from the dead by the glory of the Father, even so we also should walk in newness of life."
                        </blockquote>
                        <cite>Romans 6:4</cite>
                    </div>
                </div>

                <div class="home__quotes-item" style="animation-delay: 0.2s;">
                    <div class="home__quotes-number">IV</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "But grow in the grace and knowledge of our Lord and Savior Jesus Christ."
                        </blockquote>
                        <cite>2 Peter 3:18</cite>
                    </div>
                </div>

                <div class="home__quotes-item" style="animation-delay: 0.25s;">
                    <div class="home__quotes-number">V</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "I can do all things through Christ who strengthens me."
                        </blockquote>
                        <cite>Philippians 4:13</cite>
                    </div>
                </div>

                <div class="home__quotes-item" style="animation-delay: 0.3s;">
                    <div class="home__quotes-number">VI</div>
                    <div class="home__quotes-content">
                        <blockquote>
                            "For God so loved the world that He gave His only begotten Son, that whoever believes in Him should not perish but have everlasting life."
                        </blockquote>
                        <cite>John 3:16</cite>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="home__community">
        <div class="home__community-bg">
            <span class="home__community-tag">COMMUNITY</span>
        </div>

        <div class="wrap">
            <div class="home__community-content">
                <div class="home__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="home__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="home__community-desc">
                    Be part of a growing community of believers. Get daily encouragement, book updates, event announcements and free resources. Walk this journey together.
                </p>
                <div class="home__community-benefits">
                    <span>
                        <i class="fas fa-check-circle"></i>
                        Daily encouragement
                    </span>
                    <span>
                        <i class="fas fa-check-circle"></i>
                        Book updates
                    </span>
                    <span>
                        <i class="fas fa-check-circle"></i>
                        Baptism conversations
                    </span>
                    <span>
                        <i class="fas fa-check-circle"></i>
                        Free resources
                    </span>
                </div>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="home__community-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>Join on WhatsApp</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/home.js') }}"></script>
@endpush

@endsection