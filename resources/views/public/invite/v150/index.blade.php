@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Invite Arthur')

@section('content')

@php
    // ─── SPEAKING TOPICS ───
    $topics = [
        [
            'icon' => 'fa-cross',
            'title' => 'Faith & Identity',
            'desc' => 'What it means to walk in your God-given identity — practical teaching from Divine Identity.'
        ],
        [
            'icon' => 'fa-water',
            'title' => 'Water & Spirit Baptism',
            'desc' => 'A clear, biblical walk through water baptism and Spirit baptism — what they are and why they matter.'
        ],
        [
            'icon' => 'fa-seedling',
            'title' => 'Spiritual Growth',
            'desc' => 'From believing to being sent — equipping believers to grow, mature and walk in purpose.'
        ],
        [
            'icon' => 'fa-handshake',
            'title' => 'Community & Mission',
            'desc' => 'Building real community and living out the Great Commission in everyday life.'
        ]
    ];
@endphp

<div class="invite">

    {{-- ─── SECTION 1: HERO ─── --}}
    <section class="invite__hero">
        <div class="invite__hero-bg">
            <div class="invite__hero-gradient"></div>
            <canvas class="invite__hero-canvas" id="inviteHeroCanvas"></canvas>
        </div>

        <div class="wrap">
            <div class="invite__hero-grid">

                {{-- ─── LEFT: CONTENT ─── --}}
                <div class="invite__hero-content">
                    <span class="invite__hero-eyebrow">
                        <span class="invite__hero-eyebrow-line"></span>
                        Invite Arthur
                    </span>

                    <h1 class="invite__hero-title">
                        Bring a message<br>
                        of hope and <span>transformation.</span>
                    </h1>

                    <p class="invite__hero-text">
                        Arthur Mongalo is available for speaking engagements — church services, conferences, baptism gatherings, community events and more. Reach out and let's talk about how we can serve your event.
                    </p>

                    <div class="invite__hero-actions">
                        <a href="#invite-form" class="btn btn--primary btn--lg">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            <span>Request an Invitation</span>
                        </a>
                        <a href="tel:+27714611401" class="invite__hero-call">
                            <i class="fas fa-phone" aria-hidden="true"></i>
                            <span>Call Us</span>
                        </a>
                    </div>

                    <div class="invite__hero-features">
                        <span class="invite__hero-feature">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Speaking engagements
                        </span>
                        <span class="invite__hero-feature">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Conferences
                        </span>
                        <span class="invite__hero-feature">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Baptism services
                        </span>
                        <span class="invite__hero-feature">
                            <i class="fas fa-check-circle" aria-hidden="true"></i>
                            Community gatherings
                        </span>
                    </div>
                </div>

                {{-- ─── RIGHT: VISUAL ─── --}}
                <div class="invite__hero-visual">
                    <div class="invite__hero-image">
                        <div class="invite__hero-image-placeholder" style="background: #00ff00;">
                            <span>[PLACEHOLDER — ARTHUR SPEAKING]</span>
                        </div>
                    </div>

                    {{-- ─── FLOATING CARDS ─── --}}
                    <div class="invite__hero-float invite__hero-float--1">
                        <i class="fas fa-microphone" aria-hidden="true"></i>
                        <span>Speaking</span>
                    </div>
                    <div class="invite__hero-float invite__hero-float--2">
                        <i class="fas fa-water" aria-hidden="true"></i>
                        <span>Baptism</span>
                    </div>
                    <div class="invite__hero-float invite__hero-float--3">
                        <i class="fas fa-users" aria-hidden="true"></i>
                        <span>Community</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── SECTION 2: SPEAKING TOPICS ─── --}}
    <section class="invite__topics">
        <div class="invite__topics-bg">
            <div class="invite__topics-shape invite__topics-shape--1"></div>
            <div class="invite__topics-shape invite__topics-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What Arthur Speaks On</span>
                <h2 class="section-header__title">Speaking <span>Topics</span></h2>
                <p class="section-header__subtitle">
                    Each session is tailored to your audience, your theme and the moment you're in.
                </p>
            </div>

            <div class="invite__topics-grid">
                @foreach($topics as $topic)
                    <div class="invite__topics-card">
                        <div class="invite__topics-icon">
                            <i class="fas {{ $topic['icon'] }}"></i>
                        </div>
                        <h4 class="invite__topics-title">{{ $topic['title'] }}</h4>
                        <p class="invite__topics-desc">{{ $topic['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: FORM ─── --}}
    <section class="invite__form" id="invite-form">
        <div class="invite__form-bg">
            <div class="invite__form-shape invite__form-shape--1"></div>
            <div class="invite__form-shape invite__form-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="invite__form-grid">

                {{-- ─── LEFT: INFO ─── --}}
                <div class="invite__form-info">
                    <span class="invite__form-eyebrow">Tell Us About Your Event</span>
                    <h2 class="invite__form-title">
                        Let's make it<br>
                        <span>happen.</span>
                    </h2>
                    <p class="invite__form-desc">
                        Fill in the form with a few details about your event. Arthur will respond within 48 hours to discuss how he can serve you best.
                    </p>

                    <div class="invite__form-details">
                        <div class="invite__form-detail">
                            <div class="invite__form-detail-icon">
                                <i class="fas fa-clock" aria-hidden="true"></i>
                            </div>
                            <div class="invite__form-detail-text">
                                <span class="invite__form-detail-label">Response Time</span>
                                <span class="invite__form-detail-value">Within 48 hours</span>
                            </div>
                        </div>

                        <div class="invite__form-detail">
                            <div class="invite__form-detail-icon">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            </div>
                            <div class="invite__form-detail-text">
                                <span class="invite__form-detail-label">Based In</span>
                                <span class="invite__form-detail-value">Gauteng, South Africa</span>
                            </div>
                        </div>

                        <div class="invite__form-detail">
                            <div class="invite__form-detail-icon">
                                <i class="fas fa-globe-africa" aria-hidden="true"></i>
                            </div>
                            <div class="invite__form-detail-text">
                                <span class="invite__form-detail-label">Willing to Travel</span>
                                <span class="invite__form-detail-value">Nationally & regionally</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ─── RIGHT: FORM ─── --}}
                <div class="invite__form-wrapper">
                    <div class="invite__form-header">
                        <h3 class="invite__form-header-title">Request an Invitation</h3>
                        <p class="invite__form-header-subtitle">Fill in your details below</p>
                    </div>

                    <form method="POST" action="{{ route('invite.send') }}" class="invite__form-form form-loading">
                        @csrf

                        <div class="invite__form-row">
                            <div class="invite__form-group">
                                <label for="name">Full Name <span class="invite__form-required">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="invite__form-group">
                                <label for="email">Email Address <span class="invite__form-required">*</span></label>
                                <input type="email" name="email" id="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="invite__form-row">
                            <div class="invite__form-group">
                                <label for="phone">Phone Number <span class="invite__form-required">*</span></label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="invite__form-group">
                                <label for="expected_attendance">Expected Attendance</label>
                                <input type="number" name="expected_attendance" id="expected_attendance" placeholder="e.g., 100" value="{{ old('expected_attendance') }}" min="1">
                                @error('expected_attendance')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="invite__form-group">
                            <label for="event_name">Event Name <span class="invite__form-required">*</span></label>
                            <input type="text" name="event_name" id="event_name" placeholder="e.g., Youth Conference 2026" value="{{ old('event_name') }}" required>
                            @error('event_name')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-row">
                            <div class="invite__form-group">
                                <label for="event_date">Event Date <span class="invite__form-required">*</span></label>
                                <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" min="{{ date('Y-m-d') }}" required>
                                @error('event_date')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="invite__form-group">
                                <label for="location">Location <span class="invite__form-required">*</span></label>
                                <input type="text" name="location" id="location" placeholder="Venue, city" value="{{ old('location') }}" required>
                                @error('location')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="invite__form-group">
                            <label for="message">Message (Optional)</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us more about your event and what you'd like Arthur to speak about…">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            <span>Send Invitation Request</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: CTA BANNER ─── --}}
    <section class="invite__cta">
        <div class="invite__cta-bg">
            <div class="invite__cta-gradient"></div>
            <canvas class="invite__cta-canvas" id="inviteCtaCanvas"></canvas>
        </div>

        <div class="wrap">
            <div class="invite__cta-content">
                <div class="invite__cta-icon">
                    <i class="fas fa-handshake" aria-hidden="true"></i>
                </div>

                <h2 class="invite__cta-title">
                    Bring Arthur to<br>
                    <span>your event.</span>
                </h2>

                <p class="invite__cta-desc">
                    Speaking engagements, baptism services, conferences and community gatherings — let's talk.
                </p>

                <a href="#invite-form" class="btn btn--primary btn--lg">
                    <i class="fas fa-paper-plane" aria-hidden="true"></i>
                    <span>Request an Invitation</span>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/invite.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/invite.css') }}">
@endpush

@endsection