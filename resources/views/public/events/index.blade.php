@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Events')

@section('content')

@php
    $nextEvent = $upcomingEvents->first();
@endphp

<div class="events">

    {{-- EVENTS FLOATING ORBS --}}
    <div class="events__orbs">
        <div class="events__orb events__orb--1"></div>
        <div class="events__orb events__orb--2"></div>
        <div class="events__orb events__orb--3"></div>
        <div class="events__orb events__orb--4"></div>
        <div class="events__orb events__orb--5"></div>
    </div>

    {{-- HERO SECTION --}}
    <section class="events__hero">
        <div class="events__hero-bg">
            <div class="events__hero-orb events__hero-orb--1"></div>
            <div class="events__hero-orb events__hero-orb--2"></div>
            <div class="events__hero-orb events__hero-orb--3"></div>
            <div class="events__hero-particle events__hero-particle--1"></div>
            <div class="events__hero-particle events__hero-particle--2"></div>
            <div class="events__hero-particle events__hero-particle--3"></div>
            <div class="events__hero-particle events__hero-particle--4"></div>
            <div class="events__hero-particle events__hero-particle--5"></div>
            <div class="events__hero-pattern"></div>
        </div>
        <div class="events__hero-tag">EVENTS</div>

        <div class="wrap">
            <div class="events__hero-content">
                @if($nextEvent)
                    <span class="events__hero-badge">
                        <i class="fas fa-calendar-alt"></i> Next Event
                    </span>
                    <h1 class="events__hero-title">{{ $nextEvent->title }}</h1>
                    <p class="events__hero-text">{{ $nextEvent->description }}</p>
                    <div class="events__hero-meta">
                        <span><i class="fas fa-map-marker-alt"></i> {{ $nextEvent->location }}</span>
                        <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($nextEvent->time)->format('g:i A') }}</span>
                        <span><i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($nextEvent->date)->format('F j, Y') }}</span>
                    </div>
                @else
                    <span class="events__hero-badge">
                        <i class="fas fa-calendar-alt"></i> No Upcoming Events
                    </span>
                    <h1 class="events__hero-title">Stay <span class="events__hero-gradient">Tuned</span></h1>
                    <p class="events__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                @endif

                {{-- COUNTDOWN --}}
                <div class="events__countdown" 
                     data-event-date="{{ $nextEvent ? $nextEvent->date->format('Y-m-d') : '' }}" 
                     data-event-time="{{ $nextEvent ? $nextEvent->time : '' }}">
                    <div class="events__countdown-grid">
                        <div class="events__countdown-item">
                            <span class="events__countdown-number" id="cd-months">00</span>
                            <span class="events__countdown-label">Months</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-item">
                            <span class="events__countdown-number" id="cd-days">00</span>
                            <span class="events__countdown-label">Days</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-item">
                            <span class="events__countdown-number" id="cd-hours">00</span>
                            <span class="events__countdown-label">Hours</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-item">
                            <span class="events__countdown-number" id="cd-minutes">00</span>
                            <span class="events__countdown-label">Minutes</span>
                        </div>
                        <div class="events__countdown-divider">:</div>
                        <div class="events__countdown-item">
                            <span class="events__countdown-number" id="cd-seconds">00</span>
                            <span class="events__countdown-label">Seconds</span>
                        </div>
                    </div>
                </div>

                @if($nextEvent)
                    <div class="events__hero-actions">
                        <a href="{{ route('events.show', $nextEvent->slug) }}" class="btn btn--primary btn--lg">
                            <i class="fas fa-ticket-alt"></i> Book Your Seat
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- UPCOMING EVENTS --}}
    <section class="events__upcoming" id="upcoming-events">
        <div class="events__upcoming-bg">
            <div class="events__upcoming-shape events__upcoming-shape--1"></div>
            <div class="events__upcoming-shape events__upcoming-shape--2"></div>
        </div>
        <div class="events__upcoming-tag">UPCOMING</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Don't Miss Out</span>
                <h2 class="section-header__title">Upcoming <span>Events</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>

            <div class="events__upcoming-list">
                @forelse($upcomingEvents as $index => $event)
                    <div class="events__upcoming-card reveal" data-delay="{{ $index * 100 }}">
                        <div class="events__upcoming-date">
                            <span class="events__upcoming-day">{{ $event->date->format('d') }}</span>
                            <span class="events__upcoming-month">{{ $event->date->format('M') }}</span>
                            <span class="events__upcoming-year">{{ $event->date->format('Y') }}</span>
                        </div>
                        <div class="events__upcoming-info">
                            <span class="events__upcoming-type">
                                @if(str_contains($event->title, 'Conference')) Conference
                                @elseif(str_contains($event->title, 'Revival')) Revival
                                @elseif(str_contains($event->title, 'Gathering')) Gathering
                                @else Event @endif
                            </span>
                            <h3 class="events__upcoming-name">{{ $event->title }}</h3>
                            <p class="events__upcoming-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                            <div class="events__upcoming-meta">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
                                <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                            </div>
                        </div>
                        <div class="events__upcoming-actions">
                            <a href="{{ route('events.show', $event->slug) }}" class="btn btn--primary btn--sm">Register</a>
                        </div>
                    </div>
                @empty
                    <p class="events__upcoming-empty">No upcoming events.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- PAST EVENTS --}}
    @if($pastEvents->count() > 0)
        <section class="events__past">
            <div class="events__past-bg">
                <div class="events__past-shape events__past-shape--1"></div>
                <div class="events__past-shape events__past-shape--2"></div>
            </div>
            <div class="events__past-tag">PAST</div>
            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">Previous Gatherings</span>
                    <h2 class="section-header__title">Past <span>Events</span></h2>
                </div>
                <div class="events__past-grid">
                    @foreach($pastEvents as $index => $event)
                        <div class="events__past-card reveal" data-delay="{{ $index * 80 }}">
                            <div class="events__past-date">
                                <span class="events__past-day">{{ $event->date->format('d') }}</span>
                                <span class="events__past-month">{{ $event->date->format('M') }}</span>
                            </div>
                            <div class="events__past-info">
                                <h4 class="events__past-name">{{ $event->title }}</h4>
                                <span class="events__past-status">Completed</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- INVITE ARTHUR --}}
    <section class="events__invite">
        <div class="events__invite-bg">
            <div class="events__invite-shape events__invite-shape--1"></div>
            <div class="events__invite-shape events__invite-shape--2"></div>
        </div>
        <div class="events__invite-tag">INVITE</div>
        <div class="wrap">
            <div class="events__invite-grid">
                <div class="events__invite-content">
                    <span class="events__invite-eyebrow">Invite Arthur</span>
                    <h2 class="events__invite-title">Bring <span>Arthur</span> to Your Event</h2>
                    <p class="events__invite-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="events__invite-features">
                        <span><i class="fas fa-check-circle"></i> Speaking engagements</span>
                        <span><i class="fas fa-check-circle"></i> Book signings</span>
                        <span><i class="fas fa-check-circle"></i> Baptism services</span>
                        <span><i class="fas fa-check-circle"></i> Community gatherings</span>
                    </div>
                    <a href="{{ route('invite') }}" class="events__invite-btn">
                        <i class="fas fa-handshake"></i> Invite Arthur Now
                    </a>
                </div>
                <div class="events__invite-visual reveal reveal--right" data-delay="100">
                    <div class="events__invite-placeholder">
                        <i class="fas fa-handshake"></i>
                        <span>Let's Connect</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <section class="events__community">
        <div class="events__community-bg">
            <div class="events__community-shape events__community-shape--1"></div>
            <div class="events__community-shape events__community-shape--2"></div>
            <div class="events__community-shape events__community-shape--3"></div>
        </div>
        <div class="wrap">
            <div class="events__community-content reveal" data-delay="100">
                <div class="events__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="events__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="events__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="events__community-btn">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/events.js') }}"></script>
@endpush

@endsection