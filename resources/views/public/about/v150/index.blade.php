@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · My Story')

@section('content')

@php
    // ─── TIMELINE DATA 
    $timeline = [
        [
            'year' => '',
            'title' => 'Leading in Ministry',
            'text' => 'Led a cell group at Emmanuel Christian Church under Apostle Vincent Loate for several years, before relocating for work.'
        ],
        [
            'year' => '',
            'title' => 'A New City, A New Fellowship',
            'text' => 'Relocated to Polokwane, Limpopo. Fellowshipped at God\'s Tabernacle under Dr David Molutsi.'
        ],
        [
            'year' => '2016',
            'title' => 'Remnants Gathering Fellowship',
            'text' => 'Launched the church. Its name proved difficult for elderly people in the village to pronounce, and its eagle and dove logo was hard for members to interpret.'
        ],
        [
            'year' => '2021',
            'title' => 'Becoming Christ Tabernacle-Pneuma',
            'text' => 'Changed the name and logo to something clearer for the congregation.'
        ],
        [
            'year' => '2025',
            'title' => 'Handover to God\'s Presence Ministries',
            'text' => 'Handed the church to God\'s Presence Ministries under Reverend Cornelius Maphoto, due to relocation and collaboration.'
        ]
    ];

    // ─── A FEW THINGS ───
    $topTen = [
        'Studied Electrical Engineering, specialising in Process Instrumentation.',
        'Completed a Postgraduate Diploma in Business Management, and has a background in Project Management.',
        'Founder of two companies, MENG and Monono Holdings.',
        'Married for over 19 years, with three children.',
        'Based in Gauteng, South Africa.',
        'An ordained pastor and published author.',
        'Led a church in Limpopo for nine years.',
        'Has travelled to Lesotho, Zimbabwe, Zambia, Botswana, Ghana and the United Kingdom.'
    ];

    // ─── VALUES ───
    $values = [
        [
            'icon' => 'fa-heart',
            'title' => 'Love',
            'description' => 'The invitation extends to everyone, believers seeking assurance, those exploring faith, and people outside a church community altogether.'
        ],
        [
            'icon' => 'fa-handshake',
            'title' => 'Community',
            'description' => 'A community connecting people across church backgrounds is being built around this mission, so no one has to walk it alone.'
        ],
        [
            'icon' => 'fa-book-open',
            'title' => 'Truth',
            'description' => 'The teaching stands on Scripture, John 3:5 on being born of water and the Spirit, and the Great Commission passages that shape the ministry\'s instruction.'
        ],
        [
            'icon' => 'fa-seedling',
            'title' => 'Growth',
            'description' => 'From teaching, to water baptism, to Spirit baptism, every step is designed to prepare believers to serve.'
        ],
        [
            'icon' => 'fa-hand-holding-heart',
            'title' => 'Service',
            'description' => 'Free Christian literature, including My Salvation Companion and small Bibles, is available for churches and groups who request it.'
        ],
        [
            'icon' => 'fa-pray',
            'title' => 'Faith',
            'description' => 'Assurance does not always come easily. This ministry exists for believers still seeking that certainty, the same search that shaped Arthur\'s own journey.'
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
                        I responded to the call to accept Christ more than once before it finally took root, and I was baptised in water twice before I found real assurance. Helping others find that assurance sooner is part of why this ministry exists.
                    </p>

                    <p class="about__hero-text-secondary">
                        I am Arthur Mongalo, an ordained pastor and author, based in Gauteng, South Africa.
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
                        The First Calls<br>
                        <span>to Faith</span>
                    </h2>

                    <p class="about__story-text">
                        A travelling evangelist came to my village in the 1990s, before I was even a teenager. He made an altar call at every service, and I went forward four days in a row. I felt compelled to. I caught myself crying, feeling the need to accept Christ.
                    </p>

                    <p class="about__story-text">
                        In 1997 or 1998, I stood up again, this time at Bethesda Christian Church, visiting under Pastor Clement Ibe. I was born again, again. Both times, I felt that same need to be born again, and both times it oddly felt like God was calling me into His service too. I never doubted it was beyond just getting saved.
                    </p>

                    <blockquote class="about__story-quote">
                        <i class="fas fa-quote-left" aria-hidden="true"></i>
                        <p>"I deliberately highlighted a somewhat chaotic footing in my formative stages, getting born again over and over, getting baptised over and over again. Something I wish to help solve for others."</p>
                        - Arthur Mongalo
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

    {{-- ─── SECTION 4: MISSION & VISION ─── --}}
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
                            My mission is to teach water and Spirit baptism, and to equip believers to serve. It is for born-again Christians who lack assurance of salvation or baptism, believers who want to start their own mission but do not know where to begin, and anyone exploring faith or living outside a church community.
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
                            I have a vision to baptise at least a million people in water, pray for at least a million people, and equip every believer for spiritual growth.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: A FEW THINGS ─── --}}
    <section class="about__top10">
        <div class="about__top10-bg">
            <div class="about__top10-shape about__top10-shape--1"></div>
            <div class="about__top10-shape about__top10-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Quick Facts</span>
                <h2 class="section-header__title">A Few Things <span>About Me</span></h2>
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

    {{-- ─── SECTION 6: VALUES ─── --}}
    <section class="about__values">
        <div class="about__values-bg">
            <div class="about__values-shape about__values-shape--1"></div>
            <div class="about__values-shape about__values-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">The Foundations</span>
                <h2 class="section-header__title">What Shapes <span>This Ministry</span></h2>
                <p class="section-header__subtitle">
                    A few themes that run through the teaching, the camp and the community being built around it.
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
                    Arthur speaks on Baptisms, Divine Identity, the New Covenant and Jesus Revealed, depending on your church or event's setting.
                </p>

                <div class="about__cta-actions">
                    <a href="{{ route('invite') }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-handshake" aria-hidden="true"></i>
                        <span>Invite Arthur</span>
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