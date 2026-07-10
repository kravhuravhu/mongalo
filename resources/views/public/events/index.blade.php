@extends('layouts.app')

@section('title', 'The Collective · Events')

@section('content')

<div class="events">

    <!-- ─── HERO CALENDAR ─── -->
    <section class="events__hero">
        <div class="events__hero-bg">
            <div class="events__hero-pattern"></div>
            <div class="events__hero-shape events__hero-shape--1"></div>
            <div class="events__hero-shape events__hero-shape--2"></div>
            <div class="events__hero-shape events__hero-shape--3"></div>
        </div>

        <div class="wrap">
            <div class="events__hero-container">
                <div class="events__hero-content">
                    <span class="events__hero-badge">
                        <i class="fas fa-calendar-alt" aria-hidden="true"></i>
                        Upcoming Gatherings
                    </span>
                    <h1 class="events__hero-title">
                        Come &amp;
                        <span class="events__hero-title-highlight">Experience It</span>
                    </h1>
                    <p class="events__hero-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="events__hero-actions">
                        <a href="#events-upcoming" class="events__hero-btn events__hero-btn--primary">
                            <span>View Events</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="#events-invite" class="events__hero-btn events__hero-btn--secondary">
                            <i class="fas fa-handshake" aria-hidden="true"></i>
                            <span>Invite Arthur</span>
                        </a>
                    </div>
                </div>

                <div class="events__hero-calendar">
                    <div class="events__hero-calendar-card">
                        <div class="events__hero-calendar-header">
                            <span class="events__hero-calendar-month">{{ now()->format('F Y') }}</span>
                            <div class="events__hero-calendar-nav">
                                <button class="events__hero-calendar-nav-btn">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="events__hero-calendar-nav-btn">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="events__hero-calendar-grid">
                            <span class="events__hero-calendar-day-label">Mon</span>
                            <span class="events__hero-calendar-day-label">Tue</span>
                            <span class="events__hero-calendar-day-label">Wed</span>
                            <span class="events__hero-calendar-day-label">Thu</span>
                            <span class="events__hero-calendar-day-label">Fri</span>
                            <span class="events__hero-calendar-day-label">Sat</span>
                            <span class="events__hero-calendar-day-label">Sun</span>
                            @for($i = 1; $i <= 31; $i++)
                                @php
                                    $dayOfWeek = \Carbon\Carbon::create(null, null, $i)->dayOfWeek;
                                    $isEvent = in_array($i, [5, 12, 19, 26]);
                                @endphp
                                @if($i == 1)
                                    @for($j = 0; $j < $dayOfWeek; $j++)
                                        <span class="events__hero-calendar-empty"></span>
                                    @endfor
                                @endif
                                <span class="events__hero-calendar-day {{ $isEvent ? 'events__hero-calendar-day--event' : '' }}">
                                    {{ $i }}
                                    @if($isEvent)
                                        <span class="events__hero-calendar-day-dot"></span>
                                    @endif
                                </span>
                            @endfor
                        </div>
                        <div class="events__hero-calendar-legend">
                            <span class="events__hero-calendar-legend-item">
                                <span class="events__hero-calendar-legend-dot"></span>
                                Event Day
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── UPCOMING EVENTS ─── -->
    <section class="events__upcoming" id="events-upcoming">
        <div class="events__upcoming-bg">
            <span class="events__upcoming-tag">UPCOMING</span>
        </div>

        <div class="wrap">
            <div class="events__upcoming-header">
                <span class="events__upcoming-eyebrow">Don't Miss Out</span>
                <h2 class="events__upcoming-title">Upcoming <span>Events</span></h2>
                <p class="events__upcoming-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="events__upcoming-grid">
                @forelse($upcomingEvents as $index => $event)
                <div class="events__upcoming-card" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="events__upcoming-card-top">
                        <div class="events__upcoming-date">
                            <span class="events__upcoming-date-day">{{ $event->date->format('d') }}</span>
                            <span class="events__upcoming-date-month">{{ $event->date->format('M') }}</span>
                            <span class="events__upcoming-date-year">{{ $event->date->format('Y') }}</span>
                        </div>
                        <span class="events__upcoming-type">
                            @if(str_contains($event->title, 'Conference'))
                                <i class="fas fa-users"></i> Conference
                            @elseif(str_contains($event->title, 'Revival'))
                                <i class="fas fa-fire"></i> Revival
                            @elseif(str_contains($event->title, 'Gathering'))
                                <i class="fas fa-handshake"></i> Gathering
                            @else
                                <i class="fas fa-calendar-alt"></i> Event
                            @endif
                        </span>
                    </div>
                    <h3 class="events__upcoming-name">{{ $event->title }}</h3>
                    <p class="events__upcoming-desc">
                        {{ Str::limit($event->description ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.', 100) }}
                    </p>
                    <div class="events__upcoming-meta">
                        <span class="events__upcoming-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $event->location }}
                        </span>
                        <span class="events__upcoming-time">
                            <i class="fas fa-clock"></i>
                            {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}
                        </span>
                        @if($event->capacity)
                            <span class="events__upcoming-capacity">
                                <i class="fas fa-users"></i>
                                {{ $event->registrations()->count() ?? 0 }}/{{ $event->capacity }}
                            </span>
                        @endif
                    </div>
                    <div class="events__upcoming-actions">
                        <a href="{{ route('events.show', $event->slug) }}" class="events__upcoming-btn events__upcoming-btn--primary">
                            <span>Register Now</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#" class="events__upcoming-btn events__upcoming-btn--secondary" onclick="addToCalendar()">
                            <i class="fas fa-calendar-plus"></i>
                            <span>Add to Calendar</span>
                        </a>
                    </div>
                </div>
                @empty
                <p class="events__upcoming-empty">No upcoming events. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── PAST EVENTS ─── -->
    @if($pastEvents->count() > 0)
    <section class="events__past">
        <div class="events__past-bg">
            <span class="events__past-tag">PAST</span>
        </div>

        <div class="wrap">
            <div class="events__past-header">
                <span class="events__past-eyebrow">Previous Gatherings</span>
                <h2 class="events__past-title">Past <span>Events</span></h2>
            </div>

            <div class="events__past-grid">
                @foreach($pastEvents as $event)
                <div class="events__past-card">
                    <div class="events__past-date">
                        <span class="events__past-date-day">{{ $event->date->format('d') }}</span>
                        <span class="events__past-date-month">{{ $event->date->format('M') }}</span>
                    </div>
                    <div class="events__past-info">
                        <h4 class="events__past-name">{{ $event->title }}</h4>
                        <span class="events__past-location">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $event->location }}
                        </span>
                    </div>
                    <span class="events__past-status">
                        <i class="fas fa-check-circle"></i>
                        Completed
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── INVITE ARTHUR ─── -->
    <section class="events__invite" id="events-invite">
        <div class="events__invite-bg">
            <span class="events__invite-tag">INVITE US</span>
            <div class="events__invite-shape events__invite-shape--1"></div>
            <div class="events__invite-shape events__invite-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="events__invite-container">
                <div class="events__invite-content">
                    <span class="events__invite-eyebrow">Invite Arthur</span>
                    <h2 class="events__invite-title">
                        Bring <span>Arthur</span> to Your Event
                    </h2>
                    <p class="events__invite-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="events__invite-features">
                        <span class="events__invite-feature">
                            <i class="fas fa-microphone"></i>
                            Speaking Engagements
                        </span>
                        <span class="events__invite-feature">
                            <i class="fas fa-book"></i>
                            Book Signings
                        </span>
                        <span class="events__invite-feature">
                            <i class="fas fa-water"></i>
                            Baptism Services
                        </span>
                        <span class="events__invite-feature">
                            <i class="fas fa-users"></i>
                            Community Gatherings
                        </span>
                    </div>
                    <a href="{{ route('invite') }}" class="events__invite-btn">
                        <i class="fas fa-handshake"></i>
                        <span>Invite Arthur Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="events__invite-visual">
                    <div class="events__invite-card">
                        <div class="events__invite-card-icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <div class="events__invite-card-title">Let's Connect</div>
                        <div class="events__invite-card-text">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </div>
                        <div class="events__invite-card-line"></div>
                        <div class="events__invite-card-stats">
                            <div class="events__invite-card-stat">
                                <span class="events__invite-card-stat-number">12+</span>
                                <span class="events__invite-card-stat-label">Events</span>
                            </div>
                            <div class="events__invite-card-stat">
                                <span class="events__invite-card-stat-number">4</span>
                                <span class="events__invite-card-stat-label">Cities</span>
                            </div>
                            <div class="events__invite-card-stat">
                                <span class="events__invite-card-stat-number">500+</span>
                                <span class="events__invite-card-stat-label">Attendees</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── TESTIMONIALS ─── -->
    <section class="events__testimonials">
        <div class="events__testimonials-bg">
            <span class="events__testimonials-tag">TESTIMONIALS</span>
        </div>

        <div class="wrap">
            <div class="events__testimonials-header">
                <span class="events__testimonials-eyebrow">What People Say</span>
                <h2 class="events__testimonials-title">Event <span>Testimonials</span></h2>
            </div>

            <div class="events__testimonials-grid">
                <div class="events__testimonials-card">
                    <div class="events__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="events__testimonials-text">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                    </blockquote>
                    <div class="events__testimonials-author">
                        <span class="events__testimonials-name">Thabo M.</span>
                        <span class="events__testimonials-location">Johannesburg</span>
                    </div>
                </div>

                <div class="events__testimonials-card">
                    <div class="events__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="events__testimonials-text">
                        "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
                    </blockquote>
                    <div class="events__testimonials-author">
                        <span class="events__testimonials-name">Nomsa K.</span>
                        <span class="events__testimonials-location">Pretoria</span>
                    </div>
                </div>

                <div class="events__testimonials-card">
                    <div class="events__testimonials-stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <blockquote class="events__testimonials-text">
                        "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    </blockquote>
                    <div class="events__testimonials-author">
                        <span class="events__testimonials-name">Sipho Z.</span>
                        <span class="events__testimonials-location">Soweto</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="events__community">
        <div class="events__community-bg">
            <span class="events__community-tag">COMMUNITY</span>
        </div>

        <div class="wrap">
            <div class="events__community-content">
                <div class="events__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="events__community-title">Join <span>The Collective</span></h2>
                <p class="events__community-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                </p>
                <div class="events__community-benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="events__community-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>Join on WhatsApp</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/events.js') }}"></script>
@endpush

@endsection