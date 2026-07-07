@extends('layouts.app')

@section('title', 'The Collective · Community')

@section('content')

<div class="community">

    <!-- ─── HERO ─── -->
    <section class="community__hero">
        <div class="community__hero-bg">
            <div class="community__hero-shape community__hero-shape--1"></div>
            <div class="community__hero-shape community__hero-shape--2"></div>
            <div class="community__hero-shape community__hero-shape--3"></div>
        </div>

        <div class="wrap">
            <div class="community__hero-container">
                <div class="community__hero-content">
                    <span class="community__hero-badge">
                        <i class="fas fa-users" aria-hidden="true"></i>
                        Online Community
                    </span>
                    <h1 class="community__hero-title">
                        Join
                        <span class="community__hero-title-highlight">Us</span>
                    </h1>
                    <p class="community__hero-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                </div>

                <div class="community__hero-visual">
                    <div class="community__hero-mockup">
                        <div class="community__hero-mockup-inner">
                            <div class="community__hero-mockup-card">
                                <div class="community__hero-mockup-header">
                                    <div class="community__hero-mockup-avatar">C</div>
                                    <div class="community__hero-mockup-info">
                                        <div class="community__hero-mockup-name">The Collective Community</div>
                                        <div class="community__hero-mockup-status">
                                            <span class="community__hero-mockup-dot"></span>
                                            247 members · Active now
                                        </div>
                                    </div>
                                </div>

                                <div class="community__hero-mockup-messages">
                                    <div class="community__hero-mockup-message community__hero-mockup-message--in">
                                        <p>Good morning, family. Today's word: Lorem ipsum dolor sit amet, consectetur adipiscing elit. 🙏</p>
                                        <span class="community__hero-mockup-time">Arthur Mongalo · 6:30 AM</span>
                                    </div>

                                    <div class="community__hero-mockup-message community__hero-mockup-message--out">
                                        <p>This is exactly what I needed this morning. Thank you! 🙌</p>
                                        <span class="community__hero-mockup-time">Community member · 6:44 AM</span>
                                    </div>

                                    <div class="community__hero-mockup-message community__hero-mockup-message--in">
                                        <p><strong>Reminder</strong>: Identity in Christ Conference this Saturday. Bring someone who needs to hear this. 📖</p>
                                        <span class="community__hero-mockup-time">Arthur Mongalo · 8:02 AM</span>
                                    </div>
                                </div>

                                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="community__hero-mockup-join">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Join the Community</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── BENEFITS ─── -->
    <section class="community__benefits">
        <div class="community__benefits-bg">
            <span class="community__benefits-tag">BENEFITS</span>
        </div>

        <div class="wrap">
            <div class="community__benefits-header">
                <span class="community__benefits-eyebrow">What You Get</span>
                <h2 class="community__benefits-title">Community <span>Benefits</span></h2>
                <p class="community__benefits-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="community__benefits-grid">
                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-praying-hands"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Daily Encouragement</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-book"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Book Updates</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-water"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Baptism Conversations</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-download"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Free Resources</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Event Alerts</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4 class="community__benefits-card-title">Prayer Support</h4>
                    <p class="community__benefits-card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── TESTIMONIALS ─── -->
    <section class="community__testimonials">
        <div class="community__testimonials-bg">
            <span class="community__testimonials-tag">STORIES</span>
        </div>

        <div class="wrap">
            <div class="community__testimonials-header">
                <span class="community__testimonials-eyebrow">Real Stories</span>
                <h2 class="community__testimonials-title">What Members Are <span>Saying</span></h2>
                <p class="community__testimonials-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="community__testimonials-grid">
                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="community__testimonials-text">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                    </blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">Nomsa M.</span>
                        <span class="community__testimonials-location">Soweto, Gauteng</span>
                    </div>
                </div>

                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="community__testimonials-text">
                        "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
                    </blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">Thabo K.</span>
                        <span class="community__testimonials-location">Johannesburg, Gauteng</span>
                    </div>
                </div>

                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="community__testimonials-text">
                        "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    </blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">Palesa M.</span>
                        <span class="community__testimonials-location">Pretoria, Gauteng</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/community.js') }}"></script>
@endpush

@endsection