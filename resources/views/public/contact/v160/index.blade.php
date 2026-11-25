@extends('layouts.v160.app')

@section('title', 'Contact Us | ' . config('seo.site_name'))

@section('meta_description', 'Contact ' . config('seo.site_name') . '. Questions, prayer requests, book orders, event enquiries or invitations. Call ' . config('seo.phone') . ' or send a message online.')

@section('page-class', 'page-contact')

@push('styles')
    @include('components.v160.page-assets')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/contact.css') }}">
@endpush

@section('content')
    <div class="page page--contact">
        <x-v160.page-header />
        <div class="page__main">
            <div class="contact__grid">
                {{-- ─── LEFT: INFO ─── --}}
                <div class="contact__info">
                    <span class="page__eyebrow">Get in Touch</span>
                    <h1 class="page__title">Let's start a <span>conversation.</span></h1>
                    <p class="page__lead">Questions, prayer requests, book orders, or just want to say hello, we would love to hear from you.</p>
                    <div class="contact__items">
                        <a href="tel:{{ config('seo.phone_raw') }}" class="contact__item">
                            <span class="contact__item-icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
                            <span class="contact__item-text">
                                <small>Phone</small>
                                <strong>{{ config('seo.phone') }}</strong>
                            </span>
                        </a>
                        <a href="mailto:{{ config('seo.email') }}" class="contact__item">
                            <span class="contact__item-icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                            <span class="contact__item-text">
                                <small>Email</small>
                                <strong>{{ config('seo.email') }}</strong>
                            </span>
                        </a>
                        <x-v160.cta-link channel="whatsapp" class="contact__item">
                            <span class="contact__item-icon"><i class="fa-brands fa-whatsapp" aria-hidden="true"></i></span>
                            <span class="contact__item-text">
                                <small>WhatsApp</small>
                                <strong>Message us directly</strong>
                            </span>
                        </x-v160.cta-link>
                        <div class="contact__item contact__item--static">
                            <span class="contact__item-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                            <span class="contact__item-text">
                                <small>Location</small>
                                <strong>Gauteng, South Africa</strong>
                            </span>
                        </div>
                    </div>
                </div>
                
                {{-- ─── RIGHT: FORM ─── --}}
                <div class="page__card contact__form-card">
                    <h2 class="page__section-title">Send a <span>Message</span></h2>
                    <p class="contact__form-sub">We'll be in touch soon</p>
                    <form method="POST" action="{{ route('contact.send') }}" class="page__form form-loading">
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
                        <div class="page__row">
                            <div class="page__field">
                                <label for="phone">Phone Number (Optional)</label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" value="{{ old('phone') }}">
                                @error('phone')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                            <div class="page__field">
                                <label for="subject">Subject</label>
                                <select name="subject" id="subject" required>
                                    <option value="">Select a subject…</option>
                                    @foreach(['General Enquiry', 'Book Order', 'Event Registration', 'Invite Arthur', 'Other'] as $subject)
                                        <option value="{{ $subject }}" {{ old('subject') === $subject ? 'selected' : '' }}>{{ $subject }}</option>
                                    @endforeach
                                </select>
                                @error('subject')<span class="page__error">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="page__field">
                            <label for="message">Your Message</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us how we can help…" required>{{ old('message') }}</textarea>
                            @error('message')<span class="page__error">{{ $message }}</span>@enderror
                        </div>
                        <div class="page__field">
                            <x-turnstile />
                            @error('cf-turnstile-response')<span class="page__error">{{ $message }}</span>@enderror
                        </div>
                        <button type="submit" class="page__btn page__btn--primary page__btn--block">
                            <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                            <span>Send Message</span>
                        </button>
                        <p class="page__note"><i class="fa-solid fa-lock" aria-hidden="true"></i>Your information is safe with us.</p>
                    </form>
                </div>
            </div>
        </div>
        <x-v160.page-footer />
    </div>
@endsection