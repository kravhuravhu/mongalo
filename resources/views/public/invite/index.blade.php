@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Invite Arthur')

@section('content')

<div class="invite">

    {{-- HERO --}}
    <section class="invite__hero">
        <div class="invite__hero-bg">
            <div class="invite__hero-shape invite__hero-shape--1"></div>
            <div class="invite__hero-shape invite__hero-shape--2"></div>
            <div class="invite__hero-shape invite__hero-shape--3"></div>
        </div>
        <div class="invite__hero-tag">INVITE</div>

        <div class="wrap">
            <div class="invite__hero-grid">
                <div class="invite__hero-content">
                    <span class="invite__hero-badge">
                        <i class="fas fa-handshake"></i> Invite Arthur
                    </span>
                    <h1 class="invite__hero-title">
                        Bring Arthur to <br />
                        <span class="invite__hero-gradient">Your Event</span>
                    </h1>
                    <p class="invite__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                    <div class="invite__hero-features">
                        <span><i class="fas fa-check-circle"></i> Speaking engagements</span>
                        <span><i class="fas fa-check-circle"></i> Book signings</span>
                        <span><i class="fas fa-check-circle"></i> Baptism services</span>
                        <span><i class="fas fa-check-circle"></i> Community gatherings</span>
                        <span><i class="fas fa-check-circle"></i> Conferences</span>
                        <span><i class="fas fa-check-circle"></i> Church services</span>
                    </div>
                </div>

                <div class="invite__hero-visual">
                    <div class="invite__hero-placeholder">
                        <i class="fas fa-handshake"></i>
                        <span>Let's Connect</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FORM --}}
    <section class="invite__form">
        <div class="invite__form-tag">FORM</div>
        <div class="wrap">
            <div class="invite__form-grid">
                <div class="invite__form-info">
                    <span class="section-header__eyebrow">Tell Us About Your Event</span>
                    <h2 class="invite__form-title">Let's Make It <span>Happen</span></h2>
                    <p class="invite__form-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="invite__form-features">
                        <span><i class="fas fa-check-circle"></i> Speaking engagements</span>
                        <span><i class="fas fa-check-circle"></i> Book signings</span>
                        <span><i class="fas fa-check-circle"></i> Baptism services</span>
                        <span><i class="fas fa-check-circle"></i> Community gatherings</span>
                        <span><i class="fas fa-check-circle"></i> Conferences</span>
                        <span><i class="fas fa-check-circle"></i> Church services</span>
                    </div>
                </div>

                <div class="invite__form-wrapper">
                    @if(session('success'))
                        <div class="invite__form-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('invite.send') }}">
                        @csrf

                        <div class="invite__form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                            @error('name')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                            @error('email')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            @error('phone')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" id="event_name" placeholder="Youth Conference 2024" required>
                            @error('event_name')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-row">
                            <div class="invite__form-group">
                                <label for="event_date">Event Date</label>
                                <input type="date" name="event_date" id="event_date" required>
                                @error('event_date')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="invite__form-group">
                                <label for="expected_attendance">Expected Attendance</label>
                                <input type="number" name="expected_attendance" id="expected_attendance" placeholder="e.g., 50">
                                @error('expected_attendance')
                                    <span class="invite__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="invite__form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" placeholder="Sandton Convention Centre, Johannesburg" required>
                            @error('location')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite__form-group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us more about your event and what you'd like Arthur to speak about..."></textarea>
                            @error('message')
                                <span class="invite__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-paper-plane"></i> Send Invitation
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <section class="invite__community">
        <div class="invite__community-bg">
            <div class="invite__community-shape invite__community-shape--1"></div>
            <div class="invite__community-shape invite__community-shape--2"></div>
        </div>
        <div class="wrap">
            <div class="invite__community-content">
                <div class="invite__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="invite__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="invite__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/invite.js') }}"></script>
@endpush

@endsection