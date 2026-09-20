@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Community')

@section('content')

<div class="community">

    {{-- ─── SECTION 1: HERO ─── --}}
    <section class="community__hero">
        <div class="community__hero-bg">
            <div class="community__hero-gradient"></div>
            <canvas class="community__hero-canvas" id="communityHeroCanvas"></canvas>
        </div>

        <div class="wrap">
            <div class="community__hero-grid">

                {{-- ─── LEFT: CONTENT ─── --}}
                <div class="community__hero-content">
                    <span class="community__hero-eyebrow">
                        <span class="community__hero-eyebrow-line"></span>
                        The Community
                    </span>

                    <h1 class="community__hero-title">
                        Walk in faith.<br>
                        <span>Together.</span>
                    </h1>

                    <p class="community__hero-text">
                        A WhatsApp community for daily encouragement, prayer, book updates and conversations about baptism. No pressure — just a family walking in faith.
                    </p>

                    <div class="community__hero-actions">
                        <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            <span>Join the Community</span>
                        </a>
                    </div>

                    <p class="community__hero-note">
                        Free to join. Leave anytime. No spam.
                    </p>
                </div>

                {{-- ─── RIGHT: MOCKUP ─── --}}
                <div class="community__hero-mockup">
                    <div class="community__mockup">
                        <div class="community__mockup-phone">
                            <div class="community__mockup-notch"></div>

                            {{-- ─── CHAT HEADER (GROUP NAME) ─── --}}
                            <div class="community__mockup-header">
                                <div class="community__mockup-header-back">
                                    <i class="fas fa-chevron-left"></i>
                                </div>

                                <div class="community__mockup-header-info">
                                    <div class="community__mockup-avatar">IN</div>
                                    <div class="community__mockup-header-text">
                                        <span class="community__mockup-header-name">{{ env('PROJECT_NAME', 'IN.iN') }} Community</span>
                                        <span class="community__mockup-header-status" id="mockupStatus">
                                            <span class="community__mockup-typing-dots">
                                                <span></span><span></span><span></span>
                                            </span>
                                            typing…
                                        </span>
                                    </div>
                                </div>

                                <div class="community__mockup-header-menu">
                                    <i class="fas fa-ellipsis-v"></i>
                                </div>
                            </div>

                            {{-- ─── CHAT BODY ─── --}}
                            <div class="community__mockup-body">
                                <div class="community__mockup-msg community__mockup-msg--in">
                                    <p>Good morning family. Today's word: "Grow in the grace and knowledge of our Lord" (2 Peter 3:18). Keep growing 🙏</p>
                                    <span class="community__mockup-msg-time">6:30 AM</span>
                                </div>

                                <div class="community__mockup-msg community__mockup-msg--out">
                                    <p>This is exactly what I needed this morning. Thank you! 🙌</p>
                                    <span class="community__mockup-msg-time">6:44 AM</span>
                                </div>

                                <div class="community__mockup-msg community__mockup-msg--in community__mockup-msg--live" id="mockupLiveMsg">
                                    <p id="mockupLiveText" class="community__mockup-msg-live-text"></p>
                                    <span class="community__mockup-msg-time">now</span>
                                </div>
                            </div>

                            {{-- ─── CHAT INPUT ─── --}}
                            <div class="community__mockup-input">
                                <span class="community__mockup-input-field">
                                    <i class="fas fa-smile"></i>
                                    <span>Message</span>
                                </span>
                                <span class="community__mockup-input-mic">
                                    <i class="fas fa-microphone"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── SECTION 2: BENEFITS ─── --}}
    <section class="community__benefits">
        <div class="community__benefits-bg">
            <div class="community__benefits-shape community__benefits-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What You'll Find</span>
                <h2 class="section-header__title">Inside the <span>Community</span></h2>
            </div>

            <div class="community__benefits-grid">
                <div class="community__benefits-card">
                    <div class="community__benefits-icon">
                        <i class="fas fa-praying-hands" aria-hidden="true"></i>
                    </div>
                    <h4 class="community__benefits-title">Daily Encouragement</h4>
                    <p class="community__benefits-desc">
                        A word to start your day, shared with the whole community every morning.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-icon">
                        <i class="fas fa-book" aria-hidden="true"></i>
                    </div>
                    <h4 class="community__benefits-title">Book Updates</h4>
                    <p class="community__benefits-desc">
                        Be first to know when a new book, resource or free download drops.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-icon">
                        <i class="fas fa-hand-holding-heart" aria-hidden="true"></i>
                    </div>
                    <h4 class="community__benefits-title">Prayer Support</h4>
                    <p class="community__benefits-desc">
                        Share a need and the community prays with you. You are never carrying it alone.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: CTA BANNER ─── --}}
    <section class="community__cta">
        <div class="community__cta-bg">
            <div class="community__cta-gradient"></div>
            <canvas class="community__cta-canvas" id="communityCtaCanvas"></canvas>
        </div>

        <div class="wrap">
            <div class="community__cta-content">
                <div class="community__cta-icon">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                </div>

                <h2 class="community__cta-title">
                    Be part of<br>
                    <span>the family.</span>
                </h2>

                <p class="community__cta-desc">
                    Join the WhatsApp community today and start walking in faith with others.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/community.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/community.css') }}">
@endpush

@endsection