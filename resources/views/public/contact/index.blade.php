@extends('layouts.app')

@section('title', 'The Collective · Contact')

@section('content')

<div class="contact-page">

    <!-- ─── HERO ─── -->
    <section class="contact-hero">
        <div class="contact-hero__shapes">
            <div class="contact-hero__shape contact-hero__shape--1"></div>
            <div class="contact-hero__shape contact-hero__shape--2"></div>
            <div class="contact-hero__shape contact-hero__shape--3"></div>
        </div>

        <div class="contact-hero__tag">CONTACT</div>

        <div class="wrap">
            <div class="contact-hero__grid">
                <div class="contact-hero__content">
                    <span class="section__eyebrow">Get in Touch</span>
                    <h1 class="contact-hero__title">
                        Let's Start a <br />
                        <span class="contact-hero__title--gradient">Conversation</span>
                    </h1>
                    <p class="contact-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="contact-hero__info">
                        <div class="contact-hero__info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span class="contact-hero__info-label">Phone</span>
                                <span class="contact-hero__info-value">+27 (0) 71 461 1401</span>
                            </div>
                        </div>
                        <div class="contact-hero__info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="contact-hero__info-label">Email</span>
                                <span class="contact-hero__info-value">hello@thecollective.co.za</span>
                            </div>
                        </div>
                        <div class="contact-hero__info-item">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <span class="contact-hero__info-label">WhatsApp</span>
                                <span class="contact-hero__info-value">+27 (0) 71 461 1401</span>
                            </div>
                        </div>
                        <div class="contact-hero__info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="contact-hero__info-label">Location</span>
                                <span class="contact-hero__info-value">Gauteng, South Africa</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact-hero__image">
                    <div class="contact-hero__placeholder">
                        <i class="fas fa-comments"></i>
                        <span>Let's Connect</span>
                        <small>We reply within 24 hours</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── CONTACT FORM ─── -->
    <section class="contact-form" id="contact-form">
        <div class="contact-form__tag">MESSAGE</div>

        <div class="wrap">
            <div class="contact-form__grid">
                <div class="contact-form__info">
                    <span class="section__eyebrow">Send a Message</span>
                    <h2 class="contact-form__title">We'd Love to <span>Hear From You</span></h2>
                    <p class="contact-form__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="contact-form__trust">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>We reply within 24 hours</strong>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </div>
                    </div>
                    <div class="contact-form__trust">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>No spam, ever</strong>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </div>
                    </div>
                    <div class="contact-form__trust">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <strong>Your privacy matters</strong>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                        </div>
                    </div>
                </div>

                <div class="contact-form__form">
                    @if(session('success'))
                        <div class="contact-form__success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.send') }}">
                        @csrf

                        <div class="contact-form__row">
                            <div class="contact-form__group form_inputs_label_style">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                                @error('name')
                                    <span class="contact-form__error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact-form__group form_inputs_label_style">
                                <label for="email">Email Address</label>
                                <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                                @error('email')
                                    <span class="contact-form__error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="contact-form__group form_inputs_label_style">
                            <label for="phone">Phone Number (Optional)</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000">
                            @error('phone')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="contact-form__group form_inputs_label_style">
                            <label for="subject">Subject</label>
                            <select name="subject" id="subject" required>
                                <option value="">Select a subject...</option>
                                <option value="General Enquiry">General Enquiry</option>
                                <option value="Book Order">Book Order</option>
                                <option value="Event Registration">Event Registration</option>
                                <option value="Invite Arthur">Invite Us to your Event</option>
                                <option value="Baptism Request">Baptism Request</option>
                                <option value="Media Interview">Media Interview</option>
                                <option value="Speaking Engagement">Speaking Engagement</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('subject')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="contact-form__group form_inputs_label_style">
                            <label for="message">Your Message</label>
                            <textarea name="message" id="message" rows="5" placeholder="Tell us how we can help — we'd love to hear from you." required></textarea>
                            @error('message')
                                <span class="contact-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── WHATSAPP CTA ─── -->
    <section class="contact-whatsapp">
        <!-- <div class="contact-whatsapp__tag">COMMUNITY</div> -->

        <div class="wrap">
            <div class="contact-whatsapp__grid">
                <div class="contact-whatsapp__info">
                    <span class="section__eyebrow">Quick Connect</span>
                    <h2 class="contact-whatsapp__title">Chat with Us on <span>WhatsApp</span></h2>
                    <p class="contact-whatsapp__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="contact-whatsapp__features">
                        <div class="contact-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Fast Response</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="contact-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Personal Connection</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="contact-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Join the Community</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                        <i class="fab fa-whatsapp"></i> Message on WhatsApp
                    </a>
                </div>
                <div class="contact-whatsapp__image">
                    <div class="contact-whatsapp__placeholder">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp Community</span>
                        <small>247+ members · Active now</small>
                        <div class="contact-whatsapp__status">
                            <span class="contact-whatsapp__dot"></span>
                            We're online now
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── LOCATION ─── -->
    <section class="contact-location">
        <div class="contact-location__tag">LOCATION</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Where to Find Us</span>
                <h2 class="section__title">Based in <span>Gauteng</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="contact-location__grid">
                <div class="contact-location__map">
                    <div class="contact-location__placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Gauteng, South Africa</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
                <div class="contact-location__info">
                    <div class="contact-location__item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Phone</strong>
                            <span>+27 (0) 71 461 1401</span>
                        </div>
                    </div>
                    <div class="contact-location__item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <span>hello@thecollective.co.za</span>
                        </div>
                    </div>
                    <div class="contact-location__item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Response Time</strong>
                            <span>Within 24 hours</span>
                        </div>
                    </div>
                    <div class="contact-location__item">
                        <i class="fas fa-globe-africa"></i>
                        <div>
                            <strong>Location</strong>
                            <span>Gauteng, South Africa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection