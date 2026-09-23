@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Contact')

@section('content')

<div class="contact">

    {{-- ─── SINGLE HERO SECTION ─── --}}
    <section class="contact__hero">
        <div class="contact__hero-bg">
            <div class="contact__hero-gradient"></div>
            <canvas class="contact__hero-canvas" id="contactHeroCanvas"></canvas>
        </div>

        <div class="wrap">
            <div class="contact__hero-grid">

                {{-- ─── LEFT: INFO ─── --}}
                <div class="contact__hero-info">
                    <span class="contact__hero-eyebrow">
                        <span class="contact__hero-eyebrow-line"></span>
                        Get in Touch
                    </span>

                    <h1 class="contact__hero-title">
                        Let's start a<br>
                        <span>conversation.</span>
                    </h1>

                    <p class="contact__hero-text">
                        Questions, prayer requests, book orders, or just want to say hello — we would love to hear from you.
                    </p>

                    <div class="contact__hero-items">

                        <a href="tel:+27714611401" class="contact__hero-item">
                            <div class="contact__hero-item-icon">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="contact__hero-item-text">
                                <span class="contact__hero-item-label">Phone</span>
                                <span class="contact__hero-item-value">+27 71 461 1401</span>
                            </div>
                        </a>

                        <a href="mailto:hello@thecollective.co.za" class="contact__hero-item">
                            <div class="contact__hero-item-icon">
                                <i class="fas fa-envelope" aria-hidden="true"></i>
                            </div>
                            <div class="contact__hero-item-text">
                                <span class="contact__hero-item-label">Email</span>
                                <span class="contact__hero-item-value">hello@thecollective.co.za</span>
                            </div>
                        </a>

                        <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="contact__hero-item">
                            <div class="contact__hero-item-icon">
                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            </div>
                            <div class="contact__hero-item-text">
                                <span class="contact__hero-item-label">WhatsApp</span>
                                <span class="contact__hero-item-value">Message us directly</span>
                            </div>
                        </a>

                        <div class="contact__hero-item contact__hero-item--static">
                            <div class="contact__hero-item-icon">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                            </div>
                            <div class="contact__hero-item-text">
                                <span class="contact__hero-item-label">Location</span>
                                <span class="contact__hero-item-value">Gauteng, South Africa</span>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ─── RIGHT: FORM ─── --}}
                <div class="contact__hero-form-wrap">
                    <div class="contact__hero-form-header">
                        <h2 class="contact__hero-form-title">Send a Message</h2>
                        <p class="contact__hero-form-subtitle">We reply within 24 hours</p>
                    </div>

                    <form method="POST" action="{{ route('contact.send') }}" class="contact__hero-form form-loading">
                        @csrf

                        <div class="contact__form-row">
                            <div class="contact__form-group">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="contact__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact__form-group">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="contact__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="contact__form-row">
                            <div class="contact__form-group">
                                <label for="phone">Phone Number (Optional)</label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" value="{{ old('phone') }}">
                                @error('phone')
                                    <span class="contact__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact__form-group">
                                <label for="subject">Subject</label>
                                <select name="subject" id="subject" required>
                                    <option value="">Select a subject…</option>
                                    <option value="General Enquiry" {{ old('subject') === 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                    <option value="Book Order" {{ old('subject') === 'Book Order' ? 'selected' : '' }}>Book Order</option>
                                    <option value="Event Registration" {{ old('subject') === 'Event Registration' ? 'selected' : '' }}>Event Registration</option>
                                    <option value="Invite Arthur" {{ old('subject') === 'Invite Arthur' ? 'selected' : '' }}>Invite Arthur</option>
                                    <option value="Baptism Request" {{ old('subject') === 'Baptism Request' ? 'selected' : '' }}>Baptism Request</option>
                                    <option value="Other" {{ old('subject') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('subject')
                                    <span class="contact__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="contact__form-group">
                            <label for="message">Your Message</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us how we can help…" required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="contact__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-paper-plane" aria-hidden="true"></i>
                            <span>Send Message</span>
                        </button>

                        <p class="contact__hero-form-note">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            Your information is safe with us.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/contact.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/contact.css') }}">
@endpush

@endsection