@extends('layouts.app')

@section('title', 'Event Calendar · ' . env('PROJECT_NAME', 'The Collective'))

@section('page-class', 'page-events-calendar')

@section('content')

<div class="event-calendar">

    {{-- ─── EVENT CALENDAR FLOATING ORBS ─── --}}
    <div class="event-calendar__orbs">
        <div class="event-calendar__orb event-calendar__orb--1"></div>
        <div class="event-calendar__orb event-calendar__orb--2"></div>
        <div class="event-calendar__orb event-calendar__orb--3"></div>
        <div class="event-calendar__orb event-calendar__orb--4"></div>
        <div class="event-calendar__orb event-calendar__orb--5"></div>
    </div>

    {{-- ─── HERO ─── --}}
    <section class="event-calendar__hero">
        <div class="event-calendar__hero-bg">
            <div class="event-calendar__hero-shape event-calendar__hero-shape--1"></div>
            <div class="event-calendar__hero-shape event-calendar__hero-shape--2"></div>
            <div class="event-calendar__hero-shape event-calendar__hero-shape--3"></div>
            <div class="event-calendar__hero-particle event-calendar__hero-particle--1"></div>
            <div class="event-calendar__hero-particle event-calendar__hero-particle--2"></div>
            <div class="event-calendar__hero-particle event-calendar__hero-particle--3"></div>
            <div class="event-calendar__hero-particle event-calendar__hero-particle--4"></div>
            <div class="event-calendar__hero-particle event-calendar__hero-particle--5"></div>
        </div>
        <div class="event-calendar__hero-tag">CALENDAR</div>

        <div class="wrap">
            <div class="event-calendar__hero-content">
                <span class="event-calendar__hero-badge">
                    <i class="fas fa-calendar-alt"></i> Upcoming Events
                </span>
                <h1 class="event-calendar__hero-title">
                    Event <span class="event-calendar__hero-gradient">Calendar</span>
                </h1>
            </div>
        </div>
    </section>

    {{-- ─── CALENDAR ─── --}}
    <section class="event-calendar__main">
        <div class="wrap">
            <div class="event-calendar__main-grid">

                {{-- ─── CALENDAR GRID ─── --}}
                <div class="event-calendar__grid-wrap">
                    {{-- ─── NAVIGATION ─── --}}
                    <div class="event-calendar__nav">
                        <a href="{{ route('events.calendar', ['month' => $previousMonth->month, 'year' => $previousMonth->year]) }}" class="event-calendar__nav-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <span class="event-calendar__nav-month">
                            {{ $currentDate->format('F Y') }}
                        </span>
                        <a href="{{ route('events.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}" class="event-calendar__nav-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                    {{-- ─── DAY NAMES ─── --}}
                    <div class="event-calendar__weekdays">
                        <span class="event-calendar__weekday">Mon</span>
                        <span class="event-calendar__weekday">Tue</span>
                        <span class="event-calendar__weekday">Wed</span>
                        <span class="event-calendar__weekday">Thu</span>
                        <span class="event-calendar__weekday">Fri</span>
                        <span class="event-calendar__weekday">Sat</span>
                        <span class="event-calendar__weekday">Sun</span>
                    </div>

                    {{-- ─── CALENDAR GRID ─── --}}
                    <div class="event-calendar__grid">
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
                                        data-events="{{ json_encode($day['events']) }}"
                                        onclick="showEvents('{{ $day['date'] }}', {{ json_encode($day['events']) }})">
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

                    {{-- ─── LEGEND ─── --}}
                    <div class="event-calendar__legend">
                        <span class="event-calendar__legend-item">
                            <span class="event-calendar__legend-dot event-calendar__legend-dot--has-events"></span>
                            Has Events
                        </span>
                        <span class="event-calendar__legend-item">
                            <span class="event-calendar__legend-dot event-calendar__legend-dot--today"></span>
                            Today
                        </span>
                        <span class="event-calendar__legend-item">
                            <span class="event-calendar__legend-dot event-calendar__legend-dot--past"></span>
                            Past
                        </span>
                    </div>
                </div>

                {{-- ─── SIDEBAR ─── --}}
                <div class="event-calendar__sidebar">
                    {{-- ─── EVENT TYPES ─── --}}
                    <div class="event-calendar__sidebar-card">
                        <h3 class="event-calendar__sidebar-title">
                            <i class="fas fa-tags"></i> Event Types
                        </h3>
                        <div class="event-calendar__sidebar-types">
                            <span class="event-calendar__sidebar-type" style="background: #a67c4e;">
                                <i class="fas fa-users"></i> Conference
                            </span>
                            <span class="event-calendar__sidebar-type" style="background: #e67e22;">
                                <i class="fas fa-fire"></i> Revival
                            </span>
                            <span class="event-calendar__sidebar-type" style="background: #4A9E9E;">
                                <i class="fas fa-water"></i> Baptism
                            </span>
                            <span class="event-calendar__sidebar-type" style="background: #6f42c1;">
                                <i class="fas fa-pray"></i> Prayer
                            </span>
                            <span class="event-calendar__sidebar-type" style="background: #28a745;">
                                <i class="fas fa-music"></i> Worship
                            </span>
                            <span class="event-calendar__sidebar-type" style="background: #e8a838;">
                                <i class="fas fa-handshake"></i> Gathering
                            </span>
                        </div>
                    </div>

                    {{-- ─── UPCOMING EVENTS ─── --}}
                    <div class="event-calendar__sidebar-card">
                        <h3 class="event-calendar__sidebar-title">
                            <i class="fas fa-clock"></i> Upcoming
                        </h3>
                        <div class="event-calendar__sidebar-upcoming">
                            @forelse($upcomingEvents as $event)
                                <a href="{{ route('events.show', $event['slug']) }}" class="event-calendar__sidebar-event">
                                    <span class="event-calendar__sidebar-event-date">
                                        {{ Carbon\Carbon::parse($event['date'])->format('M d') }}
                                    </span>
                                    <span class="event-calendar__sidebar-event-info">
                                        <span class="event-calendar__sidebar-event-title">{{ $event['title'] }}</span>
                                        <span class="event-calendar__sidebar-event-time">
                                            <i class="fas fa-clock"></i> {{ $event['time'] ?? 'TBD' }}
                                        </span>
                                    </span>
                                    <span class="event-calendar__sidebar-event-dot" style="background: {{ $event['color'] }};"></span>
                                </a>
                            @empty
                                <p class="event-calendar__sidebar-empty">No upcoming events.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('events.index') }}" class="event-calendar__sidebar-link">
                            View All Events <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── EVENT DETAILS MODAL ─── --}}
    <div class="event-calendar__modal" id="eventModal">
        <div class="event-calendar__modal-overlay" onclick="closeModal()"></div>
        <div class="event-calendar__modal-content">
            <button class="event-calendar__modal-close" onclick="closeModal()">
                <i class="fas fa-times"></i>
            </button>
            <div class="event-calendar__modal-body" id="eventModalBody">
                <h3 id="modalDateTitle"></h3>
                <div id="modalEventsList"></div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    function showEvents(date, events) {
        const modal = document.getElementById('eventModal');
        const body = document.getElementById('eventModalBody');
        const title = document.getElementById('modalDateTitle');

        const dateObj = new Date(date + 'T00:00:00');
        const dateFormatted = dateObj.toLocaleDateString('en-US', {
            weekday: 'long',
            month: 'long',
            day: 'numeric',
            year: 'numeric'
        });

        title.textContent = dateFormatted;

        if (events && events.length > 0) {
            let html = '<div class="event-calendar__modal-event-list">';
            events.forEach(function(event) {
                const color = event.color || '#a67c4e';
                const isFree = event.is_free ? 'Free' : 'R' + event.price.toFixed(2);
                html += `
                    <div class="event-calendar__modal-event" style="border-left-color: ${color};">
                        <div class="event-calendar__modal-event-header">
                            <h4 class="event-calendar__modal-event-title">${event.title}</h4>
                            <span class="event-calendar__modal-event-type" style="background: ${color};">
                                ${event.type || 'Event'}
                            </span>
                        </div>
                        <div class="event-calendar__modal-event-meta">
                            ${event.time ? `<span><i class="fas fa-clock"></i> ${event.time}</span>` : ''}
                            ${event.location ? `<span><i class="fas fa-map-marker-alt"></i> ${event.location}</span>` : ''}
                            <span><i class="fas fa-tag"></i> ${isFree}</span>
                        </div>
                        ${event.description ? `<p class="event-calendar__modal-event-desc">${event.description.substring(0, 120)}${event.description.length > 120 ? '...' : ''}</p>` : ''}
                        <a href="/events/${event.slug}" class="event-calendar__modal-event-btn">
                            View Details <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                `;
            });
            html += '</div>';
            body.innerHTML = html;
        } else {
            body.innerHTML = `
                <div class="event-calendar__modal-empty">
                    <i class="fas fa-calendar-check"></i>
                    <p>No events on this day.</p>
                </div>
            `;
        }

        modal.classList.add('event-calendar__modal--open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        const modal = document.getElementById('eventModal');
        modal.classList.remove('event-calendar__modal--open');
        document.body.style.overflow = '';
    }

    // ─── CLOSE MODAL ON ESC ───
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });

    // ─── CLICK ON DAY TO SHOW EVENTS ───
    document.querySelectorAll('.event-calendar__day--has-events').forEach(function(day) {
        day.addEventListener('click', function() {
            const date = this.dataset.date;
            const events = JSON.parse(this.dataset.events);
            showEvents(date, events);
        });
    });
</script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/calendar.css') }}">
@endpush

@endsection