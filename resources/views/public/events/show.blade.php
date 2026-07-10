@extends('layouts.app')

@section('title', $event->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="event-detail">

    <!-- ─── HERO ─── -->
    <section class="event-detail__hero" style="background: linear-gradient(165deg, rgba(166,124,78,0.08) 0%, #f7f5f2 100%);">
        <div class="wrap">
            <div class="event-detail__grid">
                <div class="event-detail__info">
                    <span class="event-detail__eyebrow">Event</span>
                    <h1 class="event-detail__title">{{ $event->title }}</h1>
                    <div class="event-detail__meta">
                        <div class="event-detail__meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $event->date->format('l, F d, Y') }}</span>
                        </div>
                        <div class="event-detail__meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                        </div>
                        <div class="event-detail__meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        @if($event->capacity)
                        <div class="event-detail__meta-item">
                            <i class="fas fa-users"></i>
                            <span>{{ $event->registrations()->count() }}/{{ $event->capacity }} registered</span>
                        </div>
                        @endif
                    </div>
                    <p class="event-detail__desc">{{ $event->description }}</p>
                    <div class="event-detail__actions">
                        <button class="btn btn--primary" onclick="document.getElementById('registrationForm').scrollIntoView({behavior:'smooth'})">
                            <i class="fas fa-ticket-alt"></i> Register Now
                        </button>
                        <button class="btn btn--outline" onclick="addToCalendar()">
                            <i class="fas fa-calendar-plus"></i> Add to Calendar
                        </button>
                    </div>
                </div>
                <div class="event-detail__image">
                    <div class="event-detail__placeholder">
                        <i class="fas fa-calendar-check"></i>
                        <span>{{ $event->title }}</span>
                        <small>{{ $event->date->format('M d, Y') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── REGISTRATION FORM ─── -->
    <section class="event-detail__registration" id="registrationForm">
        <div class="event-detail__registration-tag">REGISTER</div>

        <div class="wrap">
            <div class="event-detail__registration-grid">
                <div class="event-detail__registration-info">
                    <span class="event-detail__registration-eyebrow">Secure Your Spot</span>
                    <h2 class="event-detail__registration-title">Register for <span>{{ $event->title }}</span></h2>
                    <p class="event-detail__registration-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="event-detail__registration-features">
                        <span><i class="fas fa-check-circle"></i> Free registration</span>
                        <span><i class="fas fa-check-circle"></i> Bring a friend</span>
                        <span><i class="fas fa-check-circle"></i> Certificate of attendance</span>
                        <span><i class="fas fa-check-circle"></i> WhatsApp community access</span>
                    </div>
                </div>

                <div class="event-detail__registration-form">
                    <div id="registrationMessage"></div>

                    <form id="eventRegistrationForm" method="POST" action="{{ route('events.register') }}">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event->id }}">

                        <div class="event-detail__form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                        </div>

                        <div class="event-detail__form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                        </div>

                        <div class="event-detail__form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-ticket-alt"></i> Register for Event
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── WHAT TO EXPECT ─── -->
    <section class="event-detail__expect">
        <div class="event-detail__expect-tag">EXPECT</div>

        <div class="wrap">
            <div class="event-detail__expect-header">
                <span class="event-detail__expect-eyebrow">What to Expect</span>
                <h2 class="event-detail__expect-title">A Day of <span>Transformation</span></h2>
                <p class="event-detail__expect-subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="event-detail__expect-grid">
                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon"><i class="fas fa-praying-hands"></i></div>
                    <h4>Worship</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon"><i class="fas fa-book-open"></i></div>
                    <h4>Teaching</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon"><i class="fas fa-users"></i></div>
                    <h4>Community</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="event-detail__expect-item">
                    <div class="event-detail__expect-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4>Prayer</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── INVITE ARTHUR ─── -->
    <section class="event-detail__invite">
        <div class="wrap">
            <div class="event-detail__invite-content">
                <div class="event-detail__invite-icon"><i class="fas fa-handshake"></i></div>
                <h2 class="event-detail__invite-title">Invite <span>Arthur</span> to Your Event</h2>
                <p class="event-detail__invite-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ route('invite') }}" class="btn btn--primary">
                    <i class="fas fa-handshake"></i> Invite Arthur Now
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/events.js') }}"></script>
@endpush

@endsection