@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Faith · Salvation · Baptism · Growth')

@section('content')

<div class="home">

    {{-- HOME FLOATING ORBS --}}
    <div class="home__orbs">
        <div class="home__orb home__orb--1"></div>
        <div class="home__orb home__orb--2"></div>
        <div class="home__orb home__orb--3"></div>
        <div class="home__orb home__orb--4"></div>
        <div class="home__orb home__orb--5"></div>
        <div class="home__orb home__orb--6"></div>
    </div>

    {{-- HERO SECTION --}}
    <section class="home__hero">
        <div class="home__hero-bg">
            <div class="home__hero-orb home__hero-orb--1"></div>
            <div class="home__hero-orb home__hero-orb--2"></div>
            <div class="home__hero-orb home__hero-orb--3"></div>
            <div class="home__hero-orb home__hero-orb--4"></div>
            <div class="home__hero-particle home__hero-particle--1"></div>
            <div class="home__hero-particle home__hero-particle--2"></div>
            <div class="home__hero-particle home__hero-particle--3"></div>
            <div class="home__hero-particle home__hero-particle--4"></div>
            <div class="home__hero-particle home__hero-particle--5"></div>
        </div>
        <div class="home__hero-tag">WELCOME</div>

        <div class="wrap">
            <div class="home__hero-grid">
                <div class="home__hero-content">
                    <span class="home__hero-badge">
                        <i class="fas fa-cross"></i> A Response to the Call
                    </span>
                    <h1 class="home__hero-title">
                        Welcome to<br />
                        <span class="home__hero-gradient">{{ env('PROJECT_NAME', 'The Collective') }}</span>
                    </h1>
                    <p class="home__hero-text">"Go into all the world and preach the gospel" (Mark 16:15). "Baptizing them in the name of the Father, and of the Son, and of the Holy Spirit" (Matthew 28:19). This is the call Arthur Mongalo said yes to. The goal: reach at least a million people, baptise them in water and in the Spirit, and help every one of them walk in their own purpose.</p>

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

                    {{-- Floating Icons Around Book --}}
                    <div class="home__hero-float-icon home__hero-float-icon--1">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="home__hero-float-icon home__hero-float-icon--2">
                        <i class="fas fa-water"></i>
                    </div>
                    <div class="home__hero-float-icon home__hero-float-icon--3">
                        <i class="fas fa-seedling"></i>
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
                <p class="section-header__subtitle">Every believer moves through this journey. Believing, converting, baptism and commission.</p>
            </div>

            <div class="home__pillars-layout">
                {{-- Vertical List --}}
                <div class="home__pillars-list">
                    @php
                        $pillars = [
                            [
                                'id' => 'believing',
                                'num' => 'I',
                                'icon' => 'fa-cross',
                                'title' => 'Believing',
                                'description' => 'Encountering Jesus and choosing to believe. Every journey starts here. Faith is the foundation upon which all else is built—the moment you say "yes" to Christ and begin to walk in His truth.',
                                'link' => '#'
                            ],
                            [
                                'id' => 'converting',
                                'num' => 'II',
                                'icon' => 'fa-hand-holding-heart',
                                'title' => 'Converting',
                                'description' => 'Surrendering the old ways. Repentance and forgiveness prepare the heart for what\'s next. True conversion is a turning point—leaving behind the past and embracing a new identity in Christ.',
                                'link' => '#'
                            ],
                            [
                                'id' => 'baptism',
                                'num' => 'III',
                                'icon' => 'fa-water',
                                'title' => 'Baptisms',
                                'description' => 'Water and Spirit. A clean heart, a forgiven past, a new creature (Acts 8:36-39; Acts 19:1-4). Baptism is the public declaration of your faith, symbolizing death to the old and resurrection to new life.',
                                'link' => route('baptism')
                            ],
                            [
                                'id' => 'commission',
                                'num' => 'IV',
                                'icon' => 'fa-seedling',
                                'title' => 'Commission',
                                'description' => 'Guided, supported and sent. Every believer discovers their own vision and is released into ministry. You were created for purpose—to go, to serve, and to make disciples of all nations.',
                                'link' => '#'
                            ]
                        ];
                    @endphp

                    @foreach($pillars as $index => $pillar)
                        <div class="home__pillars-item" data-pillar="{{ $pillar['id'] }}">
                            <button class="home__pillars-trigger" aria-expanded="false">
                                <span class="home__pillars-item-num">{{ $pillar['num'] }}</span>
                                <span class="home__pillars-item-icon">
                                    <i class="fas {{ $pillar['icon'] }}"></i>
                                </span>
                                <span class="home__pillars-item-title">{{ $pillar['title'] }}</span>
                                <span class="home__pillars-item-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="home__pillars-item-content">
                                <p class="home__pillars-item-desc">{{ $pillar['description'] }}</p>
                                <a href="{{ $pillar['link'] }}" class="home__pillars-item-link">
                                    Learn More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                            @if(!$loop->last)
                                <div class="home__pillars-divider"></div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Container 2: Image Display --}}
                <div class="home__pillars-image">
                    {{-- Default Image --}}
                    <div class="home__pillars-image-default">
                        <img 
                            src="{{ secure_asset('images/all_in_one_wef916wef916wef9.png') }}" 
                            alt="The Collective"
                            class="home__pillars-image-img"
                            loading="lazy"
                            onerror="this.style.display='none'"
                        >
                        <div class="home__pillars-image-overlay">
                            <div class="home__pillars-image-icon">
                                <i class="fas fa-cross"></i>
                            </div>
                            <h3 class="home__pillars-image-title">The Journey of Faith</h3>
                            <p class="home__pillars-image-desc">From believing to being sent—every step matters.</p>
                        </div>
                    </div>

                    {{-- Pillar Images (hidden by default, shown when corresponding pillar is expanded) --}}
                    @foreach($pillars as $pillar)
                        <div class="home__pillars-image-pillar" data-pillar="{{ $pillar['id'] }}">
                            <img 
                                src="{{ secure_asset('images/' . $pillar['id'] . '.jpg') }}" 
                                alt="{{ $pillar['title'] }}"
                                class="home__pillars-image-img"
                                loading="lazy"
                                onerror="this.style.display='none'"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <!-- <section class="home__community">
        <div class="home__community-bg">
            <div class="home__community-shape home__community-shape--1"></div>
            <div class="home__community-shape home__community-shape--2"></div>
            <div class="home__community-shape home__community-shape--3"></div>
        </div>
        <div class="wrap">
            <div class="home__community-content">
                <div class="home__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="home__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="home__community-desc">Join 247+ believers on WhatsApp for daily encouragement, book updates, baptism conversations and free resources. Be part of a community that walks in faith together.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section> -->

</div>

@push('scripts')
    <script src="{{ secure_asset('js/home.js') }}"></script>
@endpush

@endsection