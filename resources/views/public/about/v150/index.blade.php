@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · My Story')

@section('content')

@php
    // ─── TIMELINE DATA 
    $timeline = [
        [
            'year' => '20XX',
            'title' => '[PLACEHOLDER — Milestone Title]',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'
        ],
        [
            'year' => '20XX',
            'title' => '[PLACEHOLDER — Milestone Title]',
            'text' => 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
        ],
        [
            'year' => '20XX',
            'title' => '[PLACEHOLDER — Milestone Title]',
            'text' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.'
        ],
        [
            'year' => '20XX',
            'title' => '[PLACEHOLDER — Milestone Title]',
            'text' => 'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
        ],
        [
            'year' => '20XX',
            'title' => '[PLACEHOLDER — Milestone Title]',
            'text' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.'
        ]
    ];

    // ─── TOP 10 THINGS ───
    $topTen = [
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
        'Ut enim ad minim veniam, quis nostrud exercitation ullamco.',
        'Duis aute irure dolor in reprehenderit in voluptate velit.',
        'Excepteur sint occaecat cupidatat non proident, sunt in culpa.',
        'Sed ut perspiciatis unde omnis iste natus error sit voluptatem.',
        'Nemo enim ipsam voluptatem quia voluptas sit aspernatur.',
        'Neque porro quisquam est qui dolorem ipsum quia dolor sit amet.',
        'Ut enim ad minima veniam, quis nostrum exercitationem ullam.',
        'Quis autem vel eum iure reprehenderit qui in ea voluptate velit.'
    ];

    // ─── VALUES ───
    $values = [
        [
            'icon' => 'fa-heart',
            'title' => 'Love',
            'description' => 'We love God and love people. Every action is rooted in genuine love for others.'
        ],
        [
            'icon' => 'fa-handshake',
            'title' => 'Community',
            'description' => 'We believe we are better together. Community is a family walking through life and faith side by side.'
        ],
        [
            'icon' => 'fa-book-open',
            'title' => 'Truth',
            'description' => 'We stand on the Word of God. Scripture is our foundation, our guide and our authority.'
        ],
        [
            'icon' => 'fa-seedling',
            'title' => 'Growth',
            'description' => 'We are committed to spiritual growth. From salvation to renewal, we walk the journey together.'
        ],
        [
            'icon' => 'fa-hand-holding-heart',
            'title' => 'Service',
            'description' => 'Everything we give is offered freely, just as we have freely received.'
        ],
        [
            'icon' => 'fa-pray',
            'title' => 'Faith',
            'description' => 'We walk by faith, not by sight. Faith is our response to God\'s grace.'
        ]
    ];
@endphp

<div class="about">

    {{-- ─── SECTION 1: HERO (EDITORIAL SPLIT) ─── --}}
    <section class="about__hero">
        {{-- ─── BACKGROUND IMAGE ─── --}}
        <div class="about__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1507692049790-de58290a4334?w=1920&q=80" 
                alt="Misty mountains at dawn"
                class="about__hero-bg-img"
                loading="eager"
            >
            <div class="about__hero-overlay"></div>
            <div class="about__hero-particles" id="aboutHeroParticles"></div>
        </div>

        {{-- ─── VERTICAL SIDE LABEL ─── --}}
        <div class="about__hero-side-label">
            <span class="about__hero-side-label-text">My Story</span>
            <span class="about__hero-side-label-line"></span>
        </div>

        {{-- ─── HERO CONTENT ─── --}}
        <div class="wrap">
            <div class="about__hero-content">
                {{-- ─── LEFT: BIG TITLE ─── --}}
                <div class="about__hero-left">
                    <span class="about__hero-eyebrow">
                        <span class="about__hero-eyebrow-line"></span>
                        The Beginning
                    </span>

                    <h1 class="about__hero-title">
                        A Walk That<br>
                        Started<br>
                        <span class="about__hero-title-em">Over and Over.</span>
                    </h1>
                </div>

                {{-- ─── RIGHT: SMALL INTRO ─── --}}
                <div class="about__hero-right">
                    <p class="about__hero-text">
                        I didn't grow up with a perfect faith. I grew up getting born again over and over. Getting baptised over and over. Something I now help others avoid.
                    </p>

                    <p class="about__hero-text-secondary">
                        I am Arthur Mongalo, a speaker, & author.
                    </p>

                    <div class="about__hero-actions">
                        <a href="#story" class="about__hero-scroll-link">
                            <span>This Is My Story</span>
                            <i class="fas fa-arrow-down" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- ─── BOTTOM SCROLL INDICATOR ─── --}}
        <div class="about__hero-bottom">
            <span class="about__hero-bottom-line"></span>
            <span class="about__hero-bottom-text">Scroll</span>
        </div>
    </section>

    {{-- ─── SECTION 2: STORY INTRO ─── --}}
    <section class="about__story" id="story">
        <div class="about__story-bg">
            <div class="about__story-shape about__story-shape--1"></div>
            <div class="about__story-shape about__story-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="about__story-grid">
                {{-- ─── IMAGE LEFT ─── --}}
                <div class="about__story-visual">
                    <div class="about__story-image">
                        <div class="about__story-image-placeholder" style="background: #00ff00;">
                            <span>[PLACEHOLDER — IMAGE]</span>
                        </div>
                    </div>
                </div>

                {{-- ─── TEXT RIGHT ─── --}}
                <div class="about__story-content">
                    <span class="about__story-eyebrow">The Beginning</span>
                    <h2 class="about__story-title">
                        A Walk That Started<br>
                        <span>Over and Over</span>
                    </h2>

                    <p class="about__story-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>

                    <p class="about__story-text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>

                    <blockquote class="about__story-quote">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                        <p>"I deliberately highlighted a somewhat chaotic footing in my formative stages — getting born again over and over, getting baptised over and over again. Something I wish to help solve for others."</p>
                        <cite>— Arthur Mongalo</cite>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: TIMELINE ─── --}}
    <section class="about__timeline">
        <div class="about__timeline-bg">
            <div class="about__timeline-shape about__timeline-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">The Journey</span>
                <h2 class="section-header__title">Milestones Along <span>the Way</span></h2>
                <p class="section-header__subtitle">
                    Every step has shaped the vision. Here are the moments that mattered.
                </p>
            </div>

            <div class="about__timeline-list">
                @foreach($timeline as $index => $item)
                    <div class="about__timeline-item">
                        <div class="about__timeline-year">
                            <span>{{ $item['year'] }}</span>
                        </div>

                        <div class="about__timeline-dot">
                            <span></span>
                        </div>

                        <div class="about__timeline-content">
                            <h4 class="about__timeline-title">{{ $item['title'] }}</h4>
                            <p class="about__timeline-text">{{ $item['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: TOP 10 THINGS ─── --}}
    <section class="about__top10">
        <div class="about__top10-bg">
            <div class="about__top10-shape about__top10-shape--1"></div>
            <div class="about__top10-shape about__top10-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Quick Facts</span>
                <h2 class="section-header__title">Top 10 Things <span>About Me</span></h2>
            </div>

            <div class="about__top10-grid">
                @foreach($topTen as $index => $item)
                    <div class="about__top10-item">
                        <span class="about__top10-num">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <p class="about__top10-text">{{ $item }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: MISSION & VISION ─── --}}
    <section class="about__mv">
        <div class="about__mv-bg">
            <div class="about__mv-shape about__mv-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">The Calling</span>
                <h2 class="section-header__title">Mission &amp; <span>Vision</span></h2>
            </div>

            <div class="about__mv-grid">
                {{-- ─── MISSION ─── --}}
                <div class="about__mv-card">
                    <div class="about__mv-card-image">
                        <div class="about__mv-card-image-placeholder" style="background: #00ff00;">
                            <span>[PLACEHOLDER — IMAGE]</span>
                        </div>
                        <div class="about__mv-card-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                    </div>
                    <div class="about__mv-card-content">
                        <h3 class="about__mv-card-title">Mission</h3>
                        <p class="about__mv-card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                        </p>
                    </div>
                </div>

                {{-- ─── VISION ─── --}}
                <div class="about__mv-card">
                    <div class="about__mv-card-image">
                        <div class="about__mv-card-image-placeholder" style="background: #00ff00;">
                            <span>[PLACEHOLDER — IMAGE]</span>
                        </div>
                        <div class="about__mv-card-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>
                    <div class="about__mv-card-content">
                        <h3 class="about__mv-card-title">Vision</h3>
                        <p class="about__mv-card-text">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 6: VALUES ─── --}}
    <section class="about__values">
        <div class="about__values-bg">
            <div class="about__values-shape about__values-shape--1"></div>
            <div class="about__values-shape about__values-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What I Believe</span>
                <h2 class="section-header__title">Core <span>Values</span></h2>
                <p class="section-header__subtitle">
                    These six values shape everything I do — the mission, the resources, and how I serve the community.
                </p>
            </div>

            <div class="about__values-grid">
                @foreach($values as $value)
                    <div class="about__values-card">
                        <div class="about__values-card-icon">
                            <i class="fas {{ $value['icon'] }}"></i>
                        </div>
                        <h4 class="about__values-card-title">{{ $value['title'] }}</h4>
                        <p class="about__values-card-desc">{{ $value['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 7: CTA ─── --}}
    <section class="about__cta">
        <div class="about__cta-bg">
            <div class="about__cta-shape about__cta-shape--1"></div>
            <div class="about__cta-shape about__cta-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="about__cta-content">
                <span class="about__cta-eyebrow">Work Together</span>
                <h2 class="about__cta-title">
                    Invite Arthur<br>
                    to <span>Speak</span>
                </h2>
                <p class="about__cta-subtitle">
                    Bring a message of hope, transformation and practical faith to your church, event or organisation.
                </p>

                <div class="about__cta-actions">
                    <a href="{{ route('invite') }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-handshake" aria-hidden="true"></i>
                        <span>Request an Invitation</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/about.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/about.css') }}">
@endpush

@endsection