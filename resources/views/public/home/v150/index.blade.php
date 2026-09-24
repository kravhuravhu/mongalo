@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · I am IN Him // He is IN me')

@section('content')

<div class="home">

    {{-- ─── SECTION 1: HERO ─── --}}
    <section class="home__hero" id="homeHero">

        {{-- ─── BACKGROUND ─── --}}
        <div class="home__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80" 
                alt="Silhouette in water at sunrise"
                class="home__hero-bg-img"
                loading="eager"
            >
            <div class="home__hero-overlay"></div>
            <div class="home__hero-particles" id="heroParticles"></div>
        </div>

        {{-- ─── HERO CONTENT ─── --}}
        <div class="home__hero-content-wrap">
            <div class="wrap">
                <div class="home__hero-content">
                                        <span class="home__hero-badge">
                        <i class="fas fa-cross" aria-hidden="true"></i>
                        I am IN Him, He is IN me
                    </span>

                    <h1 class="home__hero-title">
                        A ministry of water baptism, Spirit baptism, and equipping believers to serve.
                    </h1>

                    <p class="home__hero-subtitle">
                        For believers seeking assurance or baptism, those ready to start their own mission, and anyone exploring faith for the first time.
                    </p>

                    <p class="home__hero-subtext">
                        Led by Arthur Mongalo, an ordained pastor based in Gauteng, South Africa.
                    </p>

                    <div class="home__hero-actions">
                        <a href="{{ route('baptism') }}" class="btn btn--primary btn--lg">
                            <span>Register Your Interest</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="{{ route('about') }}" class="btn btn--outline btn--lg">
                            <span>Read My Story</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── SCROLL INDICATOR ─── --}}
        <div class="home__hero-scroll">
            <span class="home__hero-scroll-line"></span>
            <span class="home__hero-scroll-text">Scroll</span>
        </div>
    </section>

        {{-- ─── SECTION 2: VISION ─── --}}
    <section class="home__vision">
        <div class="home__vision-bg">
            <div class="home__vision-shape home__vision-shape--1"></div>
            <div class="home__vision-shape home__vision-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="home__vision-content">
                <blockquote class="home__vision-quote">
                    <i class="fas fa-quote-left" aria-hidden="true"></i>
                    <p>
                        "I have a vision to baptise at least a million people in water,<br>
                        pray for at least a million people,<br>
                        and equip every believer for spiritual growth."
                    </p>
                    - Arthur Mongalo
                </blockquote>
            </div>
        </div>
    </section>

        {{-- ─── SECTION 3: THE WEEKEND CAMP ─── --}}
    <section class="home__pillars home__pillars--camp">
        <div class="home__pillars-bg">
            <div class="home__pillars-shape home__pillars-shape--1"></div>
            <div class="home__pillars-shape home__pillars-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">How It Works</span>
                <h2 class="section-header__title">The Weekend <span>Camp</span></h2>
                <p class="section-header__subtitle">
                    Teaching, water baptism and Spirit baptism, brought together over one weekend.
                </p>
            </div>

            {{-- ─── DAY STRIP ─── --}}
            <div class="home__pillars-strip">
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">Fri</span>
                    <span class="home__pillars-strip-label">Teaching</span>
                </div>
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">Sat</span>
                    <span class="home__pillars-strip-label">Water Baptism</span>
                </div>
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">Sun</span>
                    <span class="home__pillars-strip-label">Spirit Baptism</span>
                </div>
            </div>

            {{-- ─── CARDS GRID ─── --}}
            @php
                $camp = [
                    [
                        'icon' => 'fa-book-open',
                        'title' => 'Friday: Teaching',
                        'description' => 'The weekend opens with teaching on faith, identity and what it means to be baptised in water and in the Spirit.'
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => 'Saturday: Water Baptism',
                        'description' => 'A day centred on water baptism, an act of obedience and a public step in faith.'
                    ],
                    [
                        'icon' => 'fa-fire',
                        'title' => 'Sunday: Spirit Baptism',
                        'description' => 'The weekend closes with Spirit baptism, equipping believers to serve.'
                    ]
                ];
            @endphp

            <div class="home__pillars-grid">
                @foreach($camp as $day)
                    <div class="home__pillars-card">
                        <div class="home__pillars-card-icon">
                            <i class="fas {{ $day['icon'] }}"></i>
                        </div>
                        <h4 class="home__pillars-card-title">{{ $day['title'] }}</h4>
                        <p class="home__pillars-card-desc">{{ $day['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: FOUR PILLARS ─── --}}
    <section class="home__pillars">
        <div class="home__pillars-bg">
            <div class="home__pillars-shape home__pillars-shape--1"></div>
            <div class="home__pillars-shape home__pillars-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">The Journey</span>
                <h2 class="section-header__title">Four Pillars of <span>Faith</span></h2>
                <p class="section-header__subtitle">
                    Every believer moves through this journey. Believing, converting, baptism and commission.
                </p>
            </div>

            {{-- ─── ROMAN NUMERAL STRIP ─── --}}
            <div class="home__pillars-strip">
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">I</span>
                    <span class="home__pillars-strip-label">Believing</span>
                </div>
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">II</span>
                    <span class="home__pillars-strip-label">Converting</span>
                </div>
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">III</span>
                    <span class="home__pillars-strip-label">Baptisms</span>
                </div>
                <div class="home__pillars-strip-item">
                    <span class="home__pillars-strip-num">IV</span>
                    <span class="home__pillars-strip-label">Commission</span>
                </div>
            </div>

            {{-- ─── CARDS GRID ─── --}}
            @php
                $pillars = [
                    [
                        'icon' => 'fa-cross',
                        'title' => 'Believing',
                        'description' => 'Encountering Jesus and choosing to believe. Faith is the foundation upon which all else is built.'
                    ],
                    [
                        'icon' => 'fa-hand-holding-heart',
                        'title' => 'Converting',
                        'description' => 'Surrendering the old ways. Repentance prepares the heart for what comes next.'
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => 'Baptisms',
                        'description' => 'Water and Spirit together. A clean heart, a forgiven past, a new creature.'
                    ],
                    [
                        'icon' => 'fa-seedling',
                        'title' => 'Commission',
                        'description' => 'Guided, supported and sent. Every believer discovers their vision and purpose.'
                    ]
                ];
            @endphp

            <div class="home__pillars-grid">
                @foreach($pillars as $pillar)
                    <div class="home__pillars-card">
                        <div class="home__pillars-card-icon">
                            <i class="fas {{ $pillar['icon'] }}"></i>
                        </div>
                        <h4 class="home__pillars-card-title">{{ $pillar['title'] }}</h4>
                        <p class="home__pillars-card-desc">{{ $pillar['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: ARTHUR CTA ─── --}}
    <section class="home__arthur">
        <div class="home__arthur-bg">
            <div class="home__arthur-shape home__arthur-shape--1"></div>
            <div class="home__arthur-shape home__arthur-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="home__arthur-content">
                <span class="home__arthur-eyebrow">Meet the Visionary</span>
                <h2 class="home__arthur-title">
                    The story behind <span>IN.iN</span>
                </h2>
                <p class="home__arthur-subtitle">
                    Every vision has a voice. Every movement has a beginning.
                </p>

                <div class="home__arthur-actions">
                    <a href="{{ route('about') }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <span>Read My Story</span>
                    </a>
                    <a href="{{ route('invite') }}" class="btn btn--outline btn--lg">
                        <i class="fas fa-handshake" aria-hidden="true"></i>
                        <span>Invite Arthur</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/home.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/home.css') }}">
@endpush

@endsection