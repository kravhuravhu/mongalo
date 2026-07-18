@extends('layouts.app')

@section('title', $event->title . ' · ' . env('PROJECT_NAME', 'The Collective'))

@section('content')

<div class="event-detail">

    {{-- HERO --}}
    <section class="event-detail__hero">
        <div class="event-detail__hero-bg">
            <div class="event-detail__orb event-detail__orb--1"></div>
            <div class="event-detail__orb event-detail__orb--2"></div>
            <div class="event-detail__orb event-detail__orb--3"></div>
        </div>
        <div class="event-detail__hero-tag">REGISTER</div>

        <div class="wrap">
            <div class="event-detail__hero-grid">
                {{-- Event Details --}}
                <div class="event-detail__hero-content">
                    <span class="event-detail__hero-badge">
                        <i class="fas fa-calendar-alt"></i> {{ $event->date->format('l, F d, Y') }}
                    </span>
                    <h1 class="event-detail__hero-title">{{ $event->title }}</h1>
                    <p class="event-detail__hero-text">{{ $event->description }}</p>

                    <div class="event-detail__hero-meta">
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div class="event-detail__hero-meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                        </div>
                        @if($event->capacity)
                            <div class="event-detail__hero-meta-item">
                                <i class="fas fa-users"></i>
                                <span>{{ $event->registrations()->count() }}/{{ $event->capacity }} registered</span>
                            </div>
                        @endif
                    </div>

                    <div class="event-detail__hero-features">
                        <span><i class="fas fa-check-circle"></i> Free registration</span>
                        <span><i class="fas fa-check-circle"></i> Bring a friend</span>
                        <span><i class="fas fa-check-circle"></i> Certificate of attendance</span>
                    </div>
                </div>

                {{-- Registration Form --}}
                <div class="event-detail__hero-form">
                    <div class="event-detail__form-card">
                        <h3 class="event-detail__form-title">Register for This Event</h3>
                        <p class="event-detail__form-subtitle">Secure your spot — it's free!</p>

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
                                <i class="fas fa-ticket-alt"></i> Register Now
                            </button>
                        </form>

                        <p class="event-detail__form-note">
                            <i class="fas fa-lock"></i> Your information is safe with us.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHAT TO EXPECT --}}
    <section class="event-detail__expect">
        <div class="event-detail__expect-tag">EXPECT</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What to Expect</span>
                <h2 class="section-header__title">A Day of <span>Transformation</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
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

    {{-- INVITE ARTHUR --}}
    <!-- <section class="event-detail__invite">
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
    </section> -->

</div>

@push('scripts')
    <script src="{{ secure_asset('js/events.js') }}"></script>
@endpush

@endsection