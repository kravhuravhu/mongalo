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
                                    A <span class="home__hero-title-em">ministry</span> of baptisms,
                                            <span class="home__hero-title-divider">&</span>
                                                equipping <span class="home__hero-title-em">believers</span>.
                        </h1>

                    <p class="home__hero-subtitle">
                        For believers seeking assurance or baptism, people who want to serve but do not know where to begin, and anyone exploring Christianity or outside a church community.
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

    {{-- ─── SECTION 3: THE CAMP ─── --}}
    <section class="home__pillars home__pillars--camp">
        <div class="home__pillars-bg">
            <div class="home__pillars-shape home__pillars-shape--1"></div>
            <div class="home__pillars-shape home__pillars-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">How It Works</span>
                <h2 class="section-header__title">The <span>Camp</span></h2>
                <p class="section-header__subtitle">
                    Teaching, water baptism and Spirit baptism, brought together across three days.
                </p>
            </div>

            {{-- ─── CARDS GRID ─── --}}
            @php
                $camp = [
                    [
                        'icon' => 'fa-book-open',
                        'title' => 'Day 1: Teaching (Induction)',
                        'description' => 'The camp opens with teaching on faith, identity and what it means to be baptised in water and in the Spirit.'
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => 'Day 2: Water Baptism (Immersion)',
                        'description' => 'A day centred on water baptism, an act of obedience and a public step in faith.'
                    ],
                    [
                        'icon' => 'fa-fire',
                        'title' => 'Day 3: Spirit Baptism (Activation)',
                        'description' => 'The final day is centred on Spirit baptism, equipping believers to serve.'
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
                <span class="section-header__eyebrow">The Teaching</span>
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
                        'description' => 'Guided, supported and sent. Every believer is equipped to begin their own personal mission.'
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

    {{-- ─── SECTION 5: ARTHUR CTA ─── --}}
    <section class="home__arthur">
        <div class="home__arthur-bg">
            <div class="home__arthur-shape home__arthur-shape--1"></div>
            <div class="home__arthur-shape home__arthur-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="home__arthur-content">
                <span class="home__arthur-eyebrow">Meet Arthur Mongalo</span>
                <h2 class="home__arthur-title">
                    Why Arthur is starting this <span>ministry</span>
                </h2>
                <p class="home__arthur-subtitle">
                    Arthur kept responding to the call to accept Christ, and kept seeking baptism, until he found the assurance so many still search for. That search shapes everything this ministry offers.
                </p>

                <div class="home__arthur-actions">
                    <a href="{{ route('about') }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-user" aria-hidden="true"></i>
                        <span>Read Arthur's Story</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 6: WAYS TO GET INVOLVED ─── --}}
    <section class="home__pillars home__pillars--involve">
        <div class="home__pillars-bg">
            <div class="home__pillars-shape home__pillars-shape--1"></div>
            <div class="home__pillars-shape home__pillars-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Get Involved</span>
                <h2 class="section-header__title">Ways to <span>Take Part</span></h2>
                <p class="section-header__subtitle">
                    Whether you lead a church, are ready to be baptised, want to belong to a community, or need free literature for your group, there is a way in.
                </p>
            </div>

            {{-- ─── CARDS GRID ─── --}}
            @php
                $involve = [
                    [
                        'icon' => 'fa-handshake',
                        'title' => 'Invite Arthur',
                        'description' => 'Invite Arthur to personally teach on Baptisms, Divine Identity, the New Covenant, Jesus Revealed and more, depending on your setting.',
                        'route' => route('invite'),
                        'label' => 'Send an Invite'
                    ],
                    [
                        'icon' => 'fa-water',
                        'title' => 'Request Baptism',
                        'description' => 'Request to be taught about water and Spirit baptism, and take that step yourself when you are ready.',
                        'route' => route('baptism'),
                        'label' => 'Register Interest'
                    ],
                    [
                        'icon' => 'fa-people-group',
                        'title' => 'Join the Community',
                        'description' => 'Be among the first to join a community connecting people across church backgrounds around this mission.',
                        'route' => route('community'),
                        'label' => 'Join the Community'
                    ],
                    [
                        'icon' => 'fa-box-open',
                        'title' => 'Free Christian Literature',
                        'description' => 'Request free copies of My Salvation Companion, small Bibles and other Christian literature for your church or group. Delivered, couriered, or collected, all costs covered by Arthur.',
                        'route' => route('contact'),
                        'label' => 'Request Literature'
                    ]
                ];
            @endphp

            <div class="home__pillars-grid">
                @foreach($involve as $way)
                    <div class="home__pillars-card">
                        <div class="home__pillars-card-icon">
                            <i class="fas {{ $way['icon'] }}"></i>
                        </div>
                        <h4 class="home__pillars-card-title">{{ $way['title'] }}</h4>
                        <p class="home__pillars-card-desc">{{ $way['description'] }}</p>
                        <a href="{{ $way['route'] }}" class="btn btn--outline">
                            <span>{{ $way['label'] }}</span>
                        </a>
                    </div>
                @endforeach
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