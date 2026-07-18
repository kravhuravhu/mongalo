@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Community')

@section('content')

<div class="community">

    {{-- HERO — WhatsApp Community --}}
    <section class="community__hero">
        <div class="community__hero-bg">
            <div class="community__hero-shape community__hero-shape--1"></div>
            <div class="community__hero-shape community__hero-shape--2"></div>
            <div class="community__hero-shape community__hero-shape--3"></div>
            <div class="community__hero-shape community__hero-shape--4"></div>
        </div>
        <div class="community__hero-tag">COMMUNITY</div>

        <div class="wrap">
            <div class="community__hero-grid">
                <div class="community__hero-content">
                    <span class="community__hero-badge">
                        <i class="fas fa-users"></i> Join the Family
                    </span>
                    <h1 class="community__hero-title">
                        You Belong <br />
                        <span class="community__hero-gradient">Here</span>
                    </h1>
                    <p class="community__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>

                    <div class="community__hero-stats">
                        <div class="community__hero-stat">
                            <span class="community__hero-stat-number">247+</span>
                            <span class="community__hero-stat-label">Members</span>
                        </div>
                        <div class="community__hero-stat">
                            <span class="community__hero-stat-number">12+</span>
                            <span class="community__hero-stat-label">Countries</span>
                        </div>
                        <div class="community__hero-stat">
                            <span class="community__hero-stat-number">4+</span>
                            <span class="community__hero-stat-label">Books Shared</span>
                        </div>
                    </div>

                    <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                        <i class="fab fa-whatsapp"></i> Join on WhatsApp
                    </a>
                </div>

                <div class="community__hero-mockup">
                    <div class="community__hero-mockup-card">
                        <div class="community__hero-mockup-header">
                            <div class="community__hero-mockup-avatar">C</div>
                            <div>
                                <div class="community__hero-mockup-name">The Collective Community</div>
                                <div class="community__hero-mockup-status">
                                    <span class="community__hero-mockup-dot"></span>
                                    247 members · Active now
                                </div>
                            </div>
                        </div>

                        <div class="community__hero-mockup-messages">
                            <div class="community__hero-mockup-message community__hero-mockup-message--in">
                                <p>Good morning, family. Today's word: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor. 🙏</p>
                                <span class="community__hero-mockup-time">Arthur Mongalo · 6:30 AM</span>
                            </div>

                            <div class="community__hero-mockup-message community__hero-mockup-message--out">
                                <p>This is exactly what I needed this morning. Thank you! 🙌</p>
                                <span class="community__hero-mockup-time">Community member · 6:44 AM</span>
                            </div>

                            <div class="community__hero-mockup-message community__hero-mockup-message--in">
                                <p><strong>Reminder</strong>: Identity in Christ Conference this Saturday — registration link in group description. Bring someone who needs to hear this. 📖</p>
                                <span class="community__hero-mockup-time">Arthur Mongalo · 8:02 AM</span>
                            </div>
                        </div>

                        <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="community__hero-mockup-join">
                            <i class="fab fa-whatsapp"></i>
                            <span>Join the Community — It's Free</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFITS --}}
    <section class="community__benefits">
        <div class="community__benefits-tag">BENEFITS</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What You Get</span>
                <h2 class="section-header__title">Community <span>Benefits</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="community__benefits-grid">
                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-praying-hands"></i></div>
                    <h4 class="community__benefits-card-title">Daily Encouragement</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-book"></i></div>
                    <h4 class="community__benefits-card-title">Book Updates</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-water"></i></div>
                    <h4 class="community__benefits-card-title">Baptism Conversations</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-download"></i></div>
                    <h4 class="community__benefits-card-title">Free Resources</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h4 class="community__benefits-card-title">Event Alerts</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="community__benefits-card">
                    <div class="community__benefits-card-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4 class="community__benefits-card-title">Prayer Support</h4>
                    <p class="community__benefits-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="community__testimonials">
        <div class="community__testimonials-tag">STORIES</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Real Stories</span>
                <h2 class="section-header__title">What Members Are <span>Saying</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="community__testimonials-grid">
                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">★★★★★</div>
                    <blockquote class="community__testimonials-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."</blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">— Nomsa M.</span>
                        <span class="community__testimonials-location">Soweto, Gauteng</span>
                    </div>
                </div>

                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">★★★★★</div>
                    <blockquote class="community__testimonials-text">"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."</blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">— Thabo K.</span>
                        <span class="community__testimonials-location">Johannesburg, Gauteng</span>
                    </div>
                </div>

                <div class="community__testimonials-card">
                    <div class="community__testimonials-stars">★★★★★</div>
                    <blockquote class="community__testimonials-text">"Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</blockquote>
                    <div class="community__testimonials-author">
                        <span class="community__testimonials-name">— Palesa M.</span>
                        <span class="community__testimonials-location">Pretoria, Gauteng</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <!-- <section class="community__cta">
        <div class="community__cta-bg">
            <div class="community__cta-shape community__cta-shape--1"></div>
            <div class="community__cta-shape community__cta-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="community__cta-content">
                <div class="community__cta-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="community__cta-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="community__cta-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section> -->

</div>

@push('scripts')
    <script src="{{ secure_asset('js/community.js') }}"></script>
@endpush

@endsection