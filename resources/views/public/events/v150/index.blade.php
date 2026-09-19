@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Events')

@section('content')

@php
    // ─── NEXT EVENT (SOONEST UPCOMING) ───
    $nextEvent = $upcomingEvents->first();

    // ─── UPCOMING (EXCLUDING NEXT) ───
    $otherUpcoming = $upcomingEvents->skip(1);

    // ─── BUILD COUNTDOWN DATE ───
    $countdownTarget = null;
    if ($nextEvent) {
        $countdownTarget = $nextEvent->date->format('Y-m-d') . 'T' . ($nextEvent->time ?? '00:00:00');
    }
@endphp

<div class="events">

    {{-- ─── SECTION 1: HERO WITH GIANT COUNTDOWN ─── --}}
    <section class="events__hero">
        <div class="events__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=1920&q=80" 
                alt="Worship crowd with raised hands"
                class="events__hero-bg-img"
                loading="eager"
            >
            <div class="events__hero-overlay"></div>
            <div class="events__hero-particles" id="eventsHeroParticles"></div>
        </div>

        <div class="wrap">
            @if($nextEvent)
                {{-- ─── EYEBROW ─── --}}
                <span class="events__hero-eyebrow">
                    <span class="events__hero-eyebrow-line"></span>
                        Next Event
                    <span class="events__hero-eyebrow-line"></span>
                </span>

                {{-- ─── TITLE ─── --}}
                <h1 class="events__hero-title">
                    {{ $nextEvent->title }}
                </h1>

                {{-- ─── GIANT COUNTDOWN ─── --}}
                <div class="events__countdown" 
                     data-countdown-target="{{ $countdownTarget }}"
                     id="eventsCountdown">
                    <div class="events__countdown-grid">
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num" data-unit="months">00</span>
                            <span class="events__countdown-label">Months</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num" data-unit="days">00</span>
                            <span class="events__countdown-label">Days</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num" data-unit="hours">00</span>
                            <span class="events__countdown-label">Hours</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num" data-unit="minutes">00</span>
                            <span class="events__countdown-label">Minutes</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num" data-unit="seconds">00</span>
                            <span class="events__countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>

                {{-- ─── META ─── --}}
                <div class="events__hero-meta">
                    <span class="events__hero-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        {{ $nextEvent->date->format('l, F j, Y') }}
                    </span>
                    <span class="events__hero-meta-item">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::parse($nextEvent->time)->format('g:i A') }}
                    </span>
                    <span class="events__hero-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $nextEvent->location }}
                    </span>
                </div>

                {{-- ─── CTA ─── --}}
                <div class="events__hero-actions">
                    <a href="{{ route('events.show', $nextEvent->slug) }}" class="btn btn--primary btn--lg">
                        <i class="fas fa-ticket-alt" aria-hidden="true"></i>
                        <span>Register Now</span>
                    </a>
                    <a href="{{ route('events.calendar') }}" class="btn btn--outline btn--lg">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        <span>View Calendar</span>
                    </a>
                </div>
            @else
                {{-- ─── NO UPCOMING EVENTS FALLBACK ─── --}}
                <span class="events__hero-eyebrow">
                    <span class="events__hero-eyebrow-line"></span>
                    Stay Tuned
                </span>

                <h1 class="events__hero-title">
                    No Upcoming Events
                </h1>

                {{-- ─── FROZEN COUNTDOWN ─── --}}
                <div class="events__countdown events__countdown--empty">
                    <div class="events__countdown-grid">
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num">00</span>
                            <span class="events__countdown-label">Months</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num">00</span>
                            <span class="events__countdown-label">Days</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num">00</span>
                            <span class="events__countdown-label">Hours</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num">00</span>
                            <span class="events__countdown-label">Minutes</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-unit">
                            <span class="events__countdown-num">00</span>
                            <span class="events__countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>

                <p class="events__hero-empty-text">
                    Nothing on the calendar yet. Sit tight — and be the first to know by joining our WhatsApp community.
                </p>

                <div class="events__hero-actions">
                    <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                        <span>Be the First to Know</span>
                    </a>
                </div>
            @endif
        </div>

        {{-- ─── SCROLL INDICATOR ─── --}}
        <div class="events__hero-scroll">
            <span class="events__hero-scroll-line"></span>
            <span class="events__hero-scroll-text">Scroll</span>
        </div>
    </section>

    {{-- ─── SECTION 2: UPCOMING EVENTS ─── --}}
    @if($otherUpcoming->count() > 0)
        <section class="events__upcoming">
            <div class="events__upcoming-bg">
                <div class="events__upcoming-shape events__upcoming-shape--1"></div>
                <div class="events__upcoming-shape events__upcoming-shape--2"></div>
            </div>

            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">More to Come</span>
                    <h2 class="section-header__title">Upcoming <span>Events</span></h2>
                    <p class="section-header__subtitle">
                        Gatherings designed to equip, encourage and connect believers.
                    </p>
                </div>

                <div class="events__upcoming-grid">
                    @foreach($otherUpcoming as $event)
                        <div class="events__upcoming-card">
                            {{-- ─── DATE BADGE ─── --}}
                            <div class="events__upcoming-date">
                                <span class="events__upcoming-day">{{ $event->date->format('d') }}</span>
                                <span class="events__upcoming-month">{{ $event->date->format('M') }}</span>
                                <span class="events__upcoming-year">{{ $event->date->format('Y') }}</span>
                            </div>

                            {{-- ─── INFO ─── --}}
                            <div class="events__upcoming-info">
                                <h3 class="events__upcoming-title">{{ $event->title }}</h3>

                                @if($event->description)
                                    <p class="events__upcoming-desc">
                                        {{ Str::limit($event->description, 110) }}
                                    </p>
                                @endif

                                <div class="events__upcoming-meta">
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-map-marker-alt"></i>
                                        {{ $event->location }}
                                    </span>
                                </div>
                            </div>

                            {{-- ─── ACTION ─── --}}
                            <div class="events__upcoming-action">
                                <a href="{{ route('events.show', $event->slug) }}" class="events__upcoming-btn">
                                    <span>Register</span>
                                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ─── SECTION 3: PAST EVENTS ─── --}}
    @if($pastEvents->count() > 0)
        <section class="events__past">
            <div class="events__past-bg">
                <div class="events__past-shape events__past-shape--1"></div>
            </div>

            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">Previously Held</span>
                    <h2 class="section-header__title">Past <span>Events</span></h2>
                </div>

                <div class="events__past-grid">
                    @foreach($pastEvents as $event)
                        <div class="events__past-card">
                            <div class="events__past-date">
                                <span class="events__past-day">{{ $event->date->format('d') }}</span>
                                <span class="events__past-month">{{ $event->date->format('M') }}</span>
                            </div>
                            <div class="events__past-info">
                                <h4 class="events__past-title">{{ $event->title }}</h4>
                                <span class="events__past-status">
                                    <i class="fas fa-check-circle"></i>
                                    Completed
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ─── SECTION 4: INVITE STRIP ─── --}}
    <section class="events__invite">
        <div class="events__invite-bg">
            <div class="events__invite-shape events__invite-shape--1"></div>
            <div class="events__invite-shape events__invite-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="events__invite-content">
                <div class="events__invite-icon">
                    <i class="fas fa-handshake"></i>
                </div>

                <div class="events__invite-text">
                    <h3 class="events__invite-title">
                        Bring Arthur to <span>your event</span>
                    </h3>
                    <p class="events__invite-desc">
                        Speaking engagements, baptism services, conferences and community gatherings.
                    </p>
                </div>

                <a href="{{ route('invite') }}" class="events__invite-btn">
                    <span>Invite Arthur</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: CALENDAR CTA STRIP ─── --}}
    <section class="events__calendar-cta">
        <div class="events__calendar-cta-bg">
            <div class="events__calendar-cta-shape events__calendar-cta-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="events__calendar-cta-content">
                <div class="events__calendar-cta-text">
                    <span class="events__calendar-cta-eyebrow">View the Full Schedule</span>
                    <h3 class="events__calendar-cta-title">
                        Event Calendar
                    </h3>
                    <p class="events__calendar-cta-desc">
                        Every event, every date, at a glance.
                    </p>
                </div>

                <div class="events__calendar-cta-visual">
                    <div class="events__calendar-cta-calendar">
                        <span class="events__calendar-cta-calendar-month">Mon</span>
                        <span class="events__calendar-cta-calendar-day">01</span>
                    </div>
                    <div class="events__calendar-cta-calendar events__calendar-cta-calendar--alt">
                        <span class="events__calendar-cta-calendar-month">Wed</span>
                        <span class="events__calendar-cta-calendar-day">03</span>
                    </div>
                    <div class="events__calendar-cta-calendar events__calendar-cta-calendar--active">
                        <span class="events__calendar-cta-calendar-month">Sat</span>
                        <span class="events__calendar-cta-calendar-day">05</span>
                    </div>
                </div>

                <a href="{{ route('events.calendar') }}" class="events__calendar-cta-btn">
                    <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                    <span>Open Calendar</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 6: COMMUNITY CTA ─── --}}
    <section class="events__community">
        <div class="events__community-bg">
            <div class="events__community-shape events__community-shape--1"></div>
            <div class="events__community-shape events__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="events__community-content">
                <div class="events__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="events__community-title">
                    Never miss an <span>event</span>
                </h2>

                <p class="events__community-desc">
                    Join the community and be the first to hear about new events, baptisms and gatherings.
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
    <script src="{{ secure_asset('js/v150/events.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/events.css') }}">
@endpush

@endsection