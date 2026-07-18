@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Faith · Salvation · Baptism · Growth')

@section('content')

<div class="home">

    {{-- HERO SECTION --}}
    <section class="home__hero">
        <div class="home__hero-bg">
            <div class="home__hero-orb home__hero-orb--1"></div>
            <div class="home__hero-orb home__hero-orb--2"></div>
            <div class="home__hero-orb home__hero-orb--3"></div>
            <div class="home__hero-orb home__hero-orb--4"></div>
        </div>
        <div class="home__hero-tag">WELCOME</div>

        <div class="wrap">
            <div class="home__hero-grid">
                <div class="home__hero-content">
                    <span class="home__hero-badge">
                        <i class="fas fa-cross"></i> A Community of Faith · Growth · Purpose
                    </span>
                    <h1 class="home__hero-title">
                        Welcome to<br />
                        <span class="home__hero-gradient">{{ env('PROJECT_NAME', 'The Collective') }}</span>
                    </h1>
                    <p class="home__hero-text">A faith community built on one vision: to baptise at least a million people in water, pray for at least a million people and equip every believer through water baptism, Spirit baptism and the renewal of the mind. Explore our books, download free faith resources and join a growing community of believers walking in purpose.</p>

                    <div class="home__hero-actions">
                        <a href="{{ route('books.index') }}" class="btn btn--primary btn--lg">
                            <i class="fas fa-book"></i> Explore Books
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn--outline btn--lg">
                            <i class="fas fa-calendar"></i> Upcoming Events
                        </a>
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

    {{-- FOUR PILLARS --}}
    <section class="home__pillars">
        <div class="home__pillars-tag">FAITH</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Our Foundation</span>
                <h2 class="section-header__title">Four Pillars of <span>Faith</span></h2>
                <p class="section-header__subtitle">Everything we do is built on these four foundations. They shape our mission, our resources and our community.</p>
            </div>

            <div class="home__pillars-grid">
                <div class="home__pillars-card home__pillars-card--1">
                    <span class="home__pillars-num">I</span>
                    <div class="home__pillars-icon"><i class="fas fa-cross"></i></div>
                    <h3 class="home__pillars-name">Prayer</h3>
                    <p class="home__pillars-desc">Prayer is the foundation of everything we do. Through prayer we connect with God, intercede for others and invite His power into every situation. "Pray without ceasing" (1 Thessalonians 5:17). Our goal is to pray for at least a million people.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--2">
                    <span class="home__pillars-num">II</span>
                    <div class="home__pillars-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="home__pillars-name">Salvation</h3>
                    <p class="home__pillars-desc">Salvation is the starting point of every faith journey. "If you confess with your mouth the Lord Jesus and believe in your heart that God has raised Him from the dead, you will be saved" (Romans 10:9). Free resources like My Salvation Companion are here to guide you through that first step.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--3">
                    <span class="home__pillars-num">III</span>
                    <div class="home__pillars-icon"><i class="fas fa-water"></i></div>
                    <h3 class="home__pillars-name">Baptism</h3>
                    <p class="home__pillars-desc">Water baptism is an act of obedience and a public declaration of faith. "Go therefore and make disciples of all the nations, baptizing them in the name of the Father and of the Son and of the Holy Spirit" (Matthew 28:19). We believe in water baptism, Spirit baptism and the renewal of the mind.</p>
                    <a href="{{ route('baptism') }}" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="home__pillars-card home__pillars-card--4">
                    <span class="home__pillars-num">IV</span>
                    <div class="home__pillars-icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="home__pillars-name">Growth</h3>
                    <p class="home__pillars-desc">Growth does not stop at salvation. "But grow in the grace and knowledge of our Lord and Savior Jesus Christ" (2 Peter 3:18). Through Scripture, community and discipleship we continue to mature in faith. Our books and free resources support that journey every step of the way.</p>
                    <a href="#" class="home__pillars-link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <section class="home__community">
        <div class="home__community-bg">
            <div class="home__community-shape home__community-shape--1"></div>
            <div class="home__community-shape home__community-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="home__community-content">
                <div class="home__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="home__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="home__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/home.js') }}"></script>
@endpush

@endsection