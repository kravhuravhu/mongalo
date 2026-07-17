@extends('layouts.app')

@section('title', 'The Collective · About')

@section('content')

<div class="about">

    <!-- ─── HERO SPLIT ─── -->
    <section class="about__hero">
        <div class="about__hero-bg">
            <div class="about__hero-shape about__hero-shape--1"></div>
            <div class="about__hero-shape about__hero-shape--2"></div>
            <div class="about__hero-shape about__hero-shape--3"></div>
            <div class="about__hero-grid"></div>
        </div>

        <div class="wrap">
            <div class="about__hero-container">
                <div class="about__hero-content">
                    <span class="about__hero-badge">
                        <i class="fas fa-users" aria-hidden="true"></i>
                        Who We Are
                    </span>
                    <h1 class="about__hero-title">
                        A Community of
                        <span class="about__hero-title-highlight">Faith &amp; Purpose</span>
                    </h1>
                    <p class="about__hero-text">
                        The Collective is a faith community built around one purpose: to serve God and help humanity. We exist to equip believers through Scripture, community and practical resources. This is not about one person. It is about a growing body of people walking in faith together.
                    </p>
                    <div class="about__hero-actions">
                        <a href="{{ route('books.index') }}" class="about__hero-btn about__hero-btn--primary">
                            <i class="fas fa-book" aria-hidden="true"></i>
                            <span>Explore Books</span>
                        </a>
                        <a href="{{ route('community') }}" class="about__hero-btn about__hero-btn--secondary">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            <span>Join Community</span>
                        </a>
                    </div>
                </div>

                <div class="about__hero-visual">
                    <div class="about__hero-card">
                        <div class="about__hero-card-icon">
                            <i class="fas fa-cross" aria-hidden="true"></i>
                        </div>
                        <div class="about__hero-card-number">247+</div>
                        <div class="about__hero-card-label">Community Members</div>
                        <div class="about__hero-card-line"></div>
                        <div class="about__hero-card-stats">
                            <div class="about__hero-card-stat">
                                <span class="about__hero-card-stat-number">4</span>
                                <span class="about__hero-card-stat-label">Books</span>
                            </div>
                            <div class="about__hero-card-stat">
                                <span class="about__hero-card-stat-number">12+</span>
                                <span class="about__hero-card-stat-label">Events</span>
                            </div>
                            <div class="about__hero-card-stat">
                                <span class="about__hero-card-stat-number">3</span>
                                <span class="about__hero-card-stat-label">Cities</span>
                            </div>
                        </div>
                    </div>
                    <div class="about__hero-float-icons">
                        <span class="about__hero-float about__hero-float--1">
                            <i class="fas fa-hand-holding-heart"></i>
                        </span>
                        <span class="about__hero-float about__hero-float--2">
                            <i class="fas fa-water"></i>
                        </span>
                        <span class="about__hero-float about__hero-float--3">
                            <i class="fas fa-seedling"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="about__hero-scroll">
            <span class="about__hero-scroll-line"></span>
            <span class="about__hero-scroll-text">Explore</span>
        </div>
    </section>

    <!-- ─── MISSION & VISION ─── -->
    <section class="about__mission">
        <div class="about__mission-bg">
            <span class="about__mission-tag">MISSION</span>
        </div>

        <div class="wrap">
            <div class="about__mission-container">
                <div class="about__mission-item">
                    <div class="about__mission-icon">
                        <i class="fas fa-bullseye" aria-hidden="true"></i>
                    </div>
                    <h3 class="about__mission-title">Our Mission</h3>
                    <p class="about__mission-text">
                        To share the Gospel through Christian literature, free resources, community gatherings and one-on-one discipleship. We distribute books, Bibles and pamphlets, host events and create spaces where believers can grow in faith, receive prayer and be baptised.
                    </p>
                    <div class="about__mission-line"></div>
                </div>

                <div class="about__mission-divider"></div>

                <div class="about__mission-item">
                    <div class="about__mission-icon">
                        <i class="fas fa-eye" aria-hidden="true"></i>
                    </div>
                    <h3 class="about__mission-title">Our Vision</h3>
                    <p class="about__mission-text">
                        To baptise at least a million people in water, pray for at least a million people and equip every believer for spiritual growth through water baptism, Spirit baptism and the renewal of the mind. "Where there is no vision, the people perish" (Proverbs 29:18).
                    </p>
                    <div class="about__mission-line"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── OUR STORY ─── -->
    <section class="about__story">
        <div class="about__story-bg">
            <span class="about__story-tag">STORY</span>
            <div class="about__story-shape about__story-shape--1"></div>
            <div class="about__story-shape about__story-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="about__story-container">
                <div class="about__story-content">
                    <span class="about__story-eyebrow">Our Journey</span>
                    <h2 class="about__story-title">How <span>The Collective</span> Began</h2>
                    <p class="about__story-text">
                        The Collective started from a simple conviction: that faith is meant to be shared, not kept to yourself. What began as personal conversations about salvation, baptism and spiritual identity grew into something bigger. Books were written, resources were gathered and a community started forming around a shared purpose.
                    </p>
                    <p class="about__story-text">
                        Today The Collective is a growing network of believers connected through WhatsApp, events and shared resources. We distribute Christian literature freely, host gatherings across multiple cities and walk alongside people at every stage of their faith journey. The work continues to grow because the need never stops.
                    </p>
                    <div class="about__story-timeline">
                        <div class="about__story-timeline-item">
                            <span class="about__story-timeline-dot"></span>
                            <div class="about__story-timeline-content">
                                <span class="about__story-timeline-year">2020</span>
                                <span class="about__story-timeline-text">The vision was born. First conversations about faith, baptism and spiritual identity began.</span>
                            </div>
                        </div>
                        <div class="about__story-timeline-item">
                            <span class="about__story-timeline-dot"></span>
                            <div class="about__story-timeline-content">
                                <span class="about__story-timeline-year">2021</span>
                                <span class="about__story-timeline-text">Writing began on Divine Identity and the first free resources were shared.</span>
                            </div>
                        </div>
                        <div class="about__story-timeline-item">
                            <span class="about__story-timeline-dot"></span>
                            <div class="about__story-timeline-content">
                                <span class="about__story-timeline-year">2022</span>
                                <span class="about__story-timeline-text">The WhatsApp community launched and the first events were hosted.</span>
                            </div>
                        </div>
                        <div class="about__story-timeline-item">
                            <span class="about__story-timeline-dot"></span>
                            <div class="about__story-timeline-content">
                                <span class="about__story-timeline-year">2023</span>
                                <span class="about__story-timeline-text">Expanded to multiple cities. Partnerships with Gideon SA and Chick Publications formed.</span>
                            </div>
                        </div>
                        <div class="about__story-timeline-item">
                            <span class="about__story-timeline-dot"></span>
                            <div class="about__story-timeline-content">
                                <span class="about__story-timeline-year">2024</span>
                                <span class="about__story-timeline-text">Community passed 200 members. Free Bible distribution programme started.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about__story-visual">
                    <div class="about__story-card">
                        <div class="about__story-card-quote">
                            <i class="fas fa-quote-left" aria-hidden="true"></i>
                        </div>
                        <blockquote class="about__story-card-text">
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                        </blockquote>
                        <div class="about__story-card-author">
                            <span class="about__story-card-name">Arthur Mongalo</span>
                            <span class="about__story-card-title">Founder</span>
                        </div>
                        <div class="about__story-card-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── VALUES ─── -->
    <section class="about__values">
        <div class="about__values-bg">
            <span class="about__values-tag">VALUES</span>
        </div>

        <div class="wrap">
            <div class="about__values-header">
                <span class="about__values-eyebrow">What We Believe</span>
                <h2 class="about__values-title">Our Core <span>Values</span></h2>
                <p class="about__values-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="about__values-grid">
                <div class="about__values-card">
                    <div class="about__values-card-number">01</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="about__values-card-title">Love</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>

                <div class="about__values-card">
                    <div class="about__values-card-number">02</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h4 class="about__values-card-title">Community</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>

                <div class="about__values-card">
                    <div class="about__values-card-number">03</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h4 class="about__values-card-title">Truth</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>

                <div class="about__values-card">
                    <div class="about__values-card-number">04</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <h4 class="about__values-card-title">Growth</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>

                <div class="about__values-card">
                    <div class="about__values-card-number">05</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4 class="about__values-card-title">Service</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>

                <div class="about__values-card">
                    <div class="about__values-card-number">06</div>
                    <div class="about__values-card-icon">
                        <i class="fas fa-pray"></i>
                    </div>
                    <h4 class="about__values-card-title">Faith</h4>
                    <p class="about__values-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.
                    </p>
                    <div class="about__values-card-shape"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── ARTHUR MONGALO ─── -->
    <section class="about__arthur">
        <div class="about__arthur-bg">
            <span class="about__arthur-tag">ARTHUR</span>
            <div class="about__arthur-shape about__arthur-shape--1"></div>
            <div class="about__arthur-shape about__arthur-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="about__arthur-container">
                <div class="about__arthur-visual">
                    <div class="about__arthur-card">
                        <div class="about__arthur-card-icon">
                            <i class="fas fa-user" aria-hidden="true"></i>
                        </div>
                        <div class="about__arthur-card-name">Arthur Mongalo</div>
                        <div class="about__arthur-card-role">Author · Speaker · Storyteller</div>
                        <div class="about__arthur-card-line"></div>
                        <div class="about__arthur-card-socials">
                            <a href="#" class="about__arthur-card-social">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="about__arthur-card-social">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="about__arthur-card-social">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="about__arthur-content">
                    <span class="about__arthur-eyebrow">Meet Arthur</span>
                    <h2 class="about__arthur-title">A Man Shaped by <span>Real Life</span></h2>
                    <p class="about__arthur-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p class="about__arthur-text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <div class="about__arthur-quote">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                        <blockquote>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                        </blockquote>
                    </div>
                    <div class="about__arthur-actions">
                        <a href="{{ route('books.index') }}" class="about__arthur-btn about__arthur-btn--primary">
                            <i class="fas fa-book"></i>
                            <span>Explore Books</span>
                        </a>
                        <a href="{{ route('contact') }}" class="about__arthur-btn about__arthur-btn--secondary">
                            <i class="fas fa-envelope"></i>
                            <span>Get in Touch</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── STATS COUNTER ─── -->
    <section class="about__stats">
        <div class="about__stats-bg">
            <span class="about__stats-tag">IMPACT</span>
        </div>

        <div class="wrap">
            <div class="about__stats-grid">
                <div class="about__stats-item">
                    <span class="about__stats-number" data-count="247">0</span>
                    <span class="about__stats-label">Community Members</span>
                    <span class="about__stats-icon"><i class="fas fa-users"></i></span>
                </div>
                <div class="about__stats-item">
                    <span class="about__stats-number" data-count="4">0</span>
                    <span class="about__stats-label">Books Published</span>
                    <span class="about__stats-icon"><i class="fas fa-book"></i></span>
                </div>
                <div class="about__stats-item">
                    <span class="about__stats-number" data-count="12">0</span>
                    <span class="about__stats-label">Events Hosted</span>
                    <span class="about__stats-icon"><i class="fas fa-calendar-alt"></i></span>
                </div>
                <div class="about__stats-item">
                    <span class="about__stats-number" data-count="3">0</span>
                    <span class="about__stats-label">Cities Reached</span>
                    <span class="about__stats-icon"><i class="fas fa-map-marker-alt"></i></span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="about__community">
        <div class="about__community-bg">
            <span class="about__community-tag">COMMUNITY</span>
        </div>

        <div class="wrap">
            <div class="about__community-content">
                <div class="about__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="about__community-title">Join <span>The Collective</span></h2>
                <p class="about__community-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                </p>
                <div class="about__community-benefits">
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
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="about__community-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>Join on WhatsApp</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/about.js') }}"></script>
@endpush

@endsection