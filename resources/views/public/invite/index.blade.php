@extends('layouts.app')

@section('title', 'The Collective · Invite Arthur')

@section('content')

<div class="invite-page">

    <!-- ─── HERO ─── -->
    <!-- <section class="invite-hero">
        <div class="invite-hero__shapes">
            <div class="invite-hero__shape invite-hero__shape--1"></div>
            <div class="invite-hero__shape invite-hero__shape--2"></div>
            <div class="invite-hero__shape invite-hero__shape--3"></div>
        </div>

        <div class="invite-hero__tag">INVITE</div>

        <div class="wrap">
            <div class="invite-hero__grid">
                <div class="invite-hero__content">
                    <span class="section__eyebrow">Invite Arthur</span>
                    <h1 class="invite-hero__title">
                        Bring Arthur to <br />
                        <span class="invite-hero__title--gradient">Your Event</span>
                    </h1>
                    <p class="invite-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                </div>
                <div class="invite-hero__image">
                    <div class="invite-hero__placeholder">
                        <i class="fas fa-handshake"></i>
                        <span>Let's Connect</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    <!-- ─── FORM ─── -->
    <section class="invite-form">
        <div class="invite-form__tag">INVITE US</div>

        <div class="wrap">
            <div class="invite-form__grid">
                <div class="invite-form__info">
                    <span class="section__eyebrow">Tell Us About Your Event</span>
                    <h2 class="invite-form__title">Let's Make It <span>Happen</span></h2>
                    <p class="invite-form__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="invite-form__features">
                        <span><i class="fas fa-check-circle"></i> Speaking engagements</span>
                        <span><i class="fas fa-check-circle"></i> Book signings</span>
                        <span><i class="fas fa-check-circle"></i> Baptism services</span>
                        <span><i class="fas fa-check-circle"></i> Community gatherings</span>
                        <span><i class="fas fa-check-circle"></i> Conferences</span>
                        <span><i class="fas fa-check-circle"></i> Church services</span>
                    </div>
                </div>

                <div class="invite-form__form">
                    @if(session('success'))
                        <div class="invite-form__success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('invite.send') }}">
                        @csrf

                        <div class="invite-form__group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                            @error('name')
                                <span class="invite-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite-form__group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                            @error('email')
                                <span class="invite-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite-form__group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            @error('phone')
                                <span class="invite-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite-form__group">
                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" id="event_name" placeholder="Youth Conference 2024" required>
                            @error('event_name')
                                <span class="invite-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite-form__row">
                            <div class="invite-form__group">
                                <label for="event_date">Event Date</label>
                                <input type="date" name="event_date" id="event_date" required>
                                @error('event_date')
                                    <span class="invite-form__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="invite-form__group">
                                <label for="expected_attendance">Expected Attendance</label>
                                <input type="number" name="expected_attendance" id="expected_attendance" placeholder="e.g., 50">
                                @error('expected_attendance')
                                    <span class="invite-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="invite-form__group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" placeholder="Sandton Convention Centre, Johannesburg" required>
                            @error('location')
                                <span class="invite-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="invite-form__group">
                            <label for="message">Message</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us more about your event and what you'd like Arthur to speak about..."></textarea>
                            @error('message')
                                <span class="invite-form__error">{{ $message }}</span>
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

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="invite-community">
        <div class="wrap">
            <div class="invite-community__content">
                <div class="invite-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="invite-community__title">Join <span>The Collective</span></h2>
                <p class="invite-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="invite-community__benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection