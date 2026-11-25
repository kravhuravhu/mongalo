@extends('layouts.v160.app')

@section('title', 'Invite Arthur Mongalo to Speak at Your Event')

@section('meta_description', 'Invite Arthur Mongalo to teach at your church, conference, baptism service or community gathering. Speaking topics include Baptisms, Divine Identity, New Covenant and Jesus Revealed.')

@section('page-class', 'page-invite')

@push('styles')
    @include('components.v160.page-assets')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/invite.css') }}">
@endpush

@section('content')
    @php
        // ─── WHY INVITE ARTHUR ───
        $reasons = [
            ['title' => 'Nine Years of Church Leadership', 'desc' => 'An ordained pastor who led a church in Limpopo for nine years, bringing pastoral experience to every session.'],
            ['title' => 'Author of Divine Identity and My Salvation Companion', 'desc' => 'His books are already reaching people, with over 1,000 copies of My Salvation Companion distributed so far.'],
            ['title' => 'A Focus on Baptism', 'desc' => 'Water and Spirit baptism sit at the centre of his ministry, a topic he returns to and teaches in depth.'],
            ['title' => 'Teaching From His Own Journey', 'desc' => 'His concern for people still searching for assurance comes from his own search for it.'],
        ];

        // ─── SPEAKING TOPICS ───
        $topics = [
            ['icon' => 'fa-water', 'title' => 'Baptisms', 'desc' => 'A clear, biblical walk through water baptism and Spirit baptism, what they are and why they matter.'],
            ['icon' => 'fa-book-open', 'title' => 'Divine Identity', 'desc' => 'Practical teaching from his book Divine Identity, understanding who you are in Christ.'],
            ['icon' => 'fa-scroll', 'title' => 'New Covenant', 'desc' => 'Understanding what the New Covenant means for how believers live and relate to God.'],
            ['icon' => 'fa-cross', 'title' => 'Jesus Revealed', 'desc' => 'A deeper look at who Jesus is, drawing believers closer to Him.'],
        ];
    @endphp
    <div class="page page--invite">
        <x-v160.page-header />
        <div class="page__main">
            {{-- ─── SECTION 1: HERO ─── --}}
            <section class="invite__hero">
                <div class="invite__hero-text">
                    <span class="page__eyebrow">Send Invitation</span>
                    <h1 class="page__title">Invite <span>Arthur Mongalo</span> to <span>teach</span> at your event.</h1>
                    <p class="page__lead">Tell us about your gathering and what you'd like him to address.</p>
                    <div class="invite__hero-actions">
                        <a href="#invite-form" class="page__btn page__btn--primary"><i class="fa-solid fa-paper-plane" aria-hidden="true"></i> Send Invitation</a>
                        <a href="{{ route('about') }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-user" aria-hidden="true"></i> Read His Story</a>
                        <a href="tel:{{ config('seo.phone_raw') }}" class="page__btn page__btn--ghost"><i class="fa-solid fa-phone" aria-hidden="true"></i> Call Us</a>
                    </div>
                    <ul class="invite__features">
                        <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Speaking engagements</li>
                        <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Conferences</li>
                        <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Baptism services</li>
                        <li><i class="fa-solid fa-circle-check" aria-hidden="true"></i>Community gatherings</li>
                    </ul>
                </div>
                <div class="invite__hero-visual">
                    <img src="https://images.unsplash.com/photo-1475721027785-f74eccf877e2?auto=format&fit=crop&w=1000&q=80" alt="Arthur Mongalo speaking">
                    <span class="invite__float invite__float--1"><i class="fa-solid fa-microphone" aria-hidden="true"></i> Speaking</span>
                    <span class="invite__float invite__float--2"><i class="fa-solid fa-water" aria-hidden="true"></i> Baptism</span>
                    <span class="invite__float invite__float--3"><i class="fa-solid fa-users" aria-hidden="true"></i> Community</span>
                </div>
            </section>

            {{-- ─── SECTION 2: WHY INVITE ARTHUR ─── --}}
            <section class="invite__block">
                <span class="page__eyebrow">Background</span>
                <h2 class="page__section-title">Why Invite <span>Him</span></h2>
                <p class="invite__block-sub">The experience and personal journey behind his teaching.</p>
                <div class="invite__reasons">
                    @foreach($reasons as $reason)
                        <div class="page__card invite__reason">
                            <span class="invite__reason-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                            <h4>{{ $reason['title'] }}</h4>
                            <p>{{ $reason['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ─── SECTION 3: SPEAKING TOPICS ─── --}}
            <section class="invite__block">
                <span class="page__eyebrow">What He Speaks On</span>
                <h2 class="page__section-title">Speaking <span>Topics</span></h2>
                <p class="invite__block-sub">His speaking style depends on the setting. Have another topic in mind? Include it in your enquiry.</p>
                <div class="invite__topics">
                    @foreach($topics as $topic)
                        <div class="page__card invite__topic">
                            <span class="invite__topic-icon"><i class="fa-solid {{ $topic['icon'] }}" aria-hidden="true"></i></span>
                            <h4>{{ $topic['title'] }}</h4>
                            <p>{{ $topic['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
            
            {{-- ─── SECTION 4: FORM ─── --}}
            <section class="invite__form" id="invite-form">
                <div class="invite__form-info">
                    <span class="page__eyebrow">Tell Us About Your Event</span>
                    <h2 class="page__title invite__form-title">Let's discuss <span>your event.</span></h2>
                    <p class="page__lead">Fill in the form with a few details about your event. We'll review it and be in touch to discuss how he can serve you.</p>
                    <div class="invite__form-detail">
                        <i class="fa-solid fa-clock" aria-hidden="true"></i>
                        <span><small>Availability</small>Arthur responds within 48 hours.</span>
                    </div>
                </div>
                <div class="page__card invite__form-card">
                    <form method="POST" action="{{ route('invite.send') }}" class="page__form form-loading">
                        @csrf
                        <div class="page__row">
                            <div class="page__field">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
                                @error('name')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                            <div class="page__field">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                                @error('email')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="page__field">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" value="{{ old('phone') }}" required>
                            @error('phone')<span class="page__error">{{ $message }}</span>@enderror
                        </div>
                        <div class="page__row">
                            <div class="page__field">
                                <label for="event_name">Event Name</label>
                                <input type="text" name="event_name" id="event_name" placeholder="e.g. Annual Youth Conference" value="{{ old('event_name') }}" required>
                                @error('event_name')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                            <div class="page__field">
                                <label for="event_date">Event Date</label>
                                <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" min="{{ now()->addDay()->format('Y-m-d') }}" required>
                                @error('event_date')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="page__row">
                            <div class="page__field">
                                <label for="location">Location</label>
                                <input type="text" name="location" id="location" placeholder="Venue, city" value="{{ old('location') }}" required>
                                @error('location')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                            <div class="page__field">
                                <label for="expected_attendance">Expected Attendance (Optional)</label>
                                <input type="number" name="expected_attendance" id="expected_attendance" min="1" max="10000" placeholder="e.g. 250" value="{{ old('expected_attendance') }}">
                                @error('expected_attendance')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="page__field">
                            <label for="message">Anything Else? (Optional)</label>
                            <textarea name="message" id="message" rows="4" placeholder="Topic ideas, format, how long, who the audience is…">{{ old('message') }}</textarea>
                            @error('message')<span class="page__error">{{ $message }}</span>@enderror
                        </div>
                        <div class="page__field">
                            <x-turnstile />
                            @error('cf-turnstile-response')<span class="page__error">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="page__btn page__btn--primary page__btn--block">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            <span>Send Invitation</span>
                        </button>
                        <p class="page__note"><i class="fa-solid fa-lock" aria-hidden="true"></i>Your information is safe with us.</p>
                    </form>
                </div>
            </section>
        </div>
        <x-v160.page-footer />
    </div>
@endsection