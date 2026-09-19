@extends('layouts.v150.app')

@section('title', 'Event Calendar · ' . env('PROJECT_NAME', 'IN.iN'))

@section('content')

<div class="event-calendar">

    {{-- ─── SECTION 1: CALENDAR HERO ─── --}}
    <section class="event-calendar__hero">
        <div class="event-calendar__hero-bg">
            <div class="event-calendar__hero-shape event-calendar__hero-shape--1"></div>
            <div class="event-calendar__hero-shape event-calendar__hero-shape--2"></div>
            <div class="event-calendar__hero-particles" id="calendarHeroParticles"></div>
        </div>

        <div class="wrap">
            {{-- ─── HERO HEADER ─── --}}
            <div class="event-calendar__hero-header">
                <div class="event-calendar__hero-title-wrap">
                    <span class="event-calendar__hero-eyebrow">
                        <span class="event-calendar__hero-eyebrow-line"></span>
                        Schedule
                    </span>
                    <h1 class="event-calendar__hero-title">
                        Event <span>Calendar</span>
                    </h1>
                </div>

                <div class="event-calendar__hero-legend">
                    <span class="event-calendar__hero-legend-item">
                        <span class="event-calendar__hero-legend-dot event-calendar__hero-legend-dot--has-events"></span>
                        Has Events
                    </span>
                    <span class="event-calendar__hero-legend-item">
                        <span class="event-calendar__hero-legend-dot event-calendar__hero-legend-dot--today"></span>
                        Today
                    </span>
                    <span class="event-calendar__hero-legend-item">
                        <span class="event-calendar__hero-legend-dot event-calendar__hero-legend-dot--past"></span>
                        Past
                    </span>
                </div>
            </div>

            {{-- ─── MONTH NAV ─── --}}
            <div class="event-calendar__nav">
                <button type="button" class="event-calendar__nav-btn" id="calendarPrevBtn"
                        data-month="{{ $previousMonth->month }}"
                        data-year="{{ $previousMonth->year }}">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <span class="event-calendar__nav-month" id="calendarMonthLabel">
                    {{ $currentDate->format('F Y') }}
                </span>

                <button type="button" class="event-calendar__nav-btn" id="calendarNextBtn"
                        data-month="{{ $nextMonth->month }}"
                        data-year="{{ $nextMonth->year }}">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            {{-- ─── MAIN GRID ─── --}}
            <div class="event-calendar__main-grid">

                {{-- ─── CALENDAR ─── --}}
                <div class="event-calendar__grid-wrap" id="calendarGridWrap">

                    {{-- ─── LOADING SPINNER ─── --}}
                    <div class="event-calendar__grid-loader" id="calendarGridLoader">
                        <div class="event-calendar__grid-loader-spinner"></div>
                        <span class="event-calendar__grid-loader-text">Loading…</span>
                    </div>

                    {{-- ─── WEEKDAYS ─── --}}
                    <div class="event-calendar__weekdays">
                        <span class="event-calendar__weekday">Sun</span>
                        <span class="event-calendar__weekday">Mon</span>
                        <span class="event-calendar__weekday">Tue</span>
                        <span class="event-calendar__weekday">Wed</span>
                        <span class="event-calendar__weekday">Thu</span>
                        <span class="event-calendar__weekday">Fri</span>
                        <span class="event-calendar__weekday">Sat</span>
                    </div>

                    {{-- ─── GRID ─── --}}
                    <div class="event-calendar__grid" id="calendarGrid">
                        @foreach($calendarData['weeks'] as $week)
                            <div class="event-calendar__week">
                                @foreach($week as $day)
                                    @if($day === null)
                                        <div class="event-calendar__day event-calendar__day--empty"></div>
                                    @else
                                        <div class="event-calendar__day 
                                            {{ $day['is_today'] ? 'event-calendar__day--today' : '' }}
                                            {{ $day['is_past'] ? 'event-calendar__day--past' : '' }}
                                            {{ $day['has_events'] ? 'event-calendar__day--has-events' : '' }}
                                        " 
                                        data-date="{{ $day['date'] }}"
                                        data-events="{{ json_encode($day['events']) }}">
                                            <span class="event-calendar__day-number">{{ $day['day'] }}</span>

                                            @if($day['has_events'])
                                                <span class="event-calendar__day-dot"></span>
                                            @endif

                                            @if($day['event_count'] > 1)
                                                <span class="event-calendar__day-count">+{{ $day['event_count'] }}</span>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    {{-- ─── EMPTY HINT ─── --}}
                    <div class="event-calendar__empty-hint" id="calendarEmptyHint"
                         style="{{ collect($calendarData['weeks'])->filter()->flatten(1)->filter(fn($d) => is_array($d) && !empty($d['has_events']))->count() > 0 ? 'display: none;' : '' }}">
                        <i class="fas fa-calendar-day"></i>
                        <span>No events scheduled this month.</span>
                    </div>
                </div>

                {{-- ─── SIDEBAR ─── --}}
                <div class="event-calendar__sidebar">

                    <div class="event-calendar__sidebar-card">
                        <h3 class="event-calendar__sidebar-title">
                            <i class="fas fa-clock"></i>
                            Upcoming
                        </h3>

                        <div class="event-calendar__sidebar-upcoming">
                            @forelse($upcomingEvents as $event)
                                <a href="{{ route('events.show', $event['slug']) }}" class="event-calendar__sidebar-event">
                                    <span class="event-calendar__sidebar-event-date">
                                        {{ \Carbon\Carbon::parse($event['date'])->format('M d') }}
                                    </span>

                                    <span class="event-calendar__sidebar-event-info">
                                        <span class="event-calendar__sidebar-event-title">{{ $event['title'] }}</span>
                                        <span class="event-calendar__sidebar-event-time">
                                            <i class="fas fa-clock"></i>
                                            {{ $event['time'] ?? 'TBD' }}
                                        </span>
                                    </span>

                                    <span class="event-calendar__sidebar-event-dot" style="background: {{ $event['color'] }};"></span>
                                </a>
                            @empty
                                <p class="event-calendar__sidebar-empty">
                                    No upcoming events.
                                </p>
                            @endforelse
                        </div>

                        <a href="{{ route('events.index') }}" class="event-calendar__sidebar-link">
                            <span>View All Events</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="event-calendar__sidebar-card">
                        <h3 class="event-calendar__sidebar-title">
                            <i class="fas fa-tags"></i>
                            Event Types
                        </h3>

                        <div class="event-calendar__sidebar-types">
                            <span class="event-calendar__sidebar-type" style="--type-color: #a67c4e;">
                                <i class="fas fa-users"></i> Conference
                            </span>
                            <span class="event-calendar__sidebar-type" style="--type-color: #e67e22;">
                                <i class="fas fa-fire"></i> Revival
                            </span>
                            <span class="event-calendar__sidebar-type" style="--type-color: #4A9E9E;">
                                <i class="fas fa-water"></i> Baptism
                            </span>
                            <span class="event-calendar__sidebar-type" style="--type-color: #6f42c1;">
                                <i class="fas fa-pray"></i> Prayer
                            </span>
                            <span class="event-calendar__sidebar-type" style="--type-color: #28a745;">
                                <i class="fas fa-music"></i> Worship
                            </span>
                            <span class="event-calendar__sidebar-type" style="--type-color: #e8a838;">
                                <i class="fas fa-handshake"></i> Gathering
                            </span>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 2: OTHER EVENTS STRIP ─── --}}
    <section class="event-calendar__other">
        <div class="event-calendar__other-bg">
            <div class="event-calendar__other-shape event-calendar__other-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="event-calendar__other-content">
                <div class="event-calendar__other-icon">
                    <i class="fas fa-list"></i>
                </div>

                <div class="event-calendar__other-text">
                    <h3 class="event-calendar__other-title">
                        See the full <span>line-up</span>
                    </h3>
                    <p class="event-calendar__other-desc">
                        Browse upcoming and past events in one place.
                    </p>
                </div>

                <a href="{{ route('events.index') }}" class="event-calendar__other-btn">
                    <span>All Events</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: COMMUNITY CTA ─── --}}
    <section class="event-calendar__community">
        <div class="event-calendar__community-bg">
            <div class="event-calendar__community-shape event-calendar__community-shape--1"></div>
            <div class="event-calendar__community-shape event-calendar__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="event-calendar__community-content">
                <div class="event-calendar__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="event-calendar__community-title">
                    Never miss an <span>event</span>
                </h2>

                <p class="event-calendar__community-desc">
                    Join the community and be the first to hear about new events and gatherings.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── MODAL ─── --}}
    <div class="event-calendar__modal" id="eventModal">
        <div class="event-calendar__modal-overlay" onclick="closeCalendarModal()"></div>

        <div class="event-calendar__modal-content">
            <button class="event-calendar__modal-close" onclick="closeCalendarModal()" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>

            <div class="event-calendar__modal-body" id="eventModalBody">
                <h3 class="event-calendar__modal-title" id="modalDateTitle"></h3>
                <div id="modalEventsList"></div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/calendar.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/calendar.css') }}">
@endpush

@endsection