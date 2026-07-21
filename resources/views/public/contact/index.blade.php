@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Contact')

@section('content')

<div class="contact">

    {{-- CONTACT FLOATING ORBS --}}
    <div class="contact__orbs">
        <div class="contact__orb contact__orb--1"></div>
        <div class="contact__orb contact__orb--2"></div>
        <div class="contact__orb contact__orb--3"></div>
        <div class="contact__orb contact__orb--4"></div>
        <div class="contact__orb contact__orb--5"></div>
    </div>

    {{-- HERO --}}
    <section class="contact__hero">
        <div class="contact__hero-bg">
            <div class="contact__hero-shape contact__hero-shape--1"></div>
            <div class="contact__hero-shape contact__hero-shape--2"></div>
            <div class="contact__hero-shape contact__hero-shape--3"></div>
            <div class="contact__hero-particle contact__hero-particle--1"></div>
            <div class="contact__hero-particle contact__hero-particle--2"></div>
            <div class="contact__hero-particle contact__hero-particle--3"></div>
            <div class="contact__hero-particle contact__hero-particle--4"></div>
            <div class="contact__hero-particle contact__hero-particle--5"></div>
        </div>
        <div class="contact__hero-tag">CONTACT</div>

        <div class="wrap">
            <div class="contact__hero-grid">
                <div class="contact__hero-content">
                    <span class="contact__hero-badge">
                        <i class="fas fa-envelope"></i> Get in Touch
                    </span>
                    <h1 class="contact__hero-title">
                        Let's Start a <br />
                        <span class="contact__hero-gradient">Conversation</span>
                    </h1>
                    <p class="contact__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>

                    <div class="contact__hero-info">
                        <div class="contact__hero-info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <span class="contact__hero-info-label">Phone</span>
                                <span class="contact__hero-info-value">+27 (0) 71 461 1401</span>
                            </div>
                        </div>
                        <div class="contact__hero-info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <span class="contact__hero-info-label">Email</span>
                                <span class="contact__hero-info-value">hello@thecollective.co.za</span>
                            </div>
                        </div>
                        <div class="contact__hero-info-item">
                            <i class="fab fa-whatsapp"></i>
                            <div>
                                <span class="contact__hero-info-label">WhatsApp</span>
                                <span class="contact__hero-info-value">+27 (0) 71 461 1401</span>
                            </div>
                        </div>
                        <div class="contact__hero-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <span class="contact__hero-info-label">Location</span>
                                <span class="contact__hero-info-value">Gauteng, South Africa</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact__hero-form">
                    <div class="contact__hero-form-card">
                        <h3 class="contact__hero-form-title">Send a Message</h3>
                        <p class="contact__hero-form-subtitle">We reply within 24 hours</p>

                        @if(session('success'))
                            <div class="contact__hero-form-success">
                                <i class="fas fa-check-circle"></i> {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.send') }}">
                            @csrf

                            <div class="contact__hero-form-row">
                                <div class="contact__hero-form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                                    @error('name')
                                        <span class="contact__hero-form-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="contact__hero-form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                                    @error('email')
                                        <span class="contact__hero-form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="contact__hero-form-group">
                                <label for="phone">Phone Number (Optional)</label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000">
                                @error('phone')
                                    <span class="contact__hero-form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact__hero-form-group">
                                <label for="subject">Subject</label>
                                <select name="subject" id="subject" required>
                                    <option value="">Select a subject...</option>
                                    <option value="General Enquiry">General Enquiry</option>
                                    <option value="Book Order">Book Order</option>
                                    <option value="Event Registration">Event Registration</option>
                                    <option value="Invite Arthur">Invite Arthur</option>
                                    <option value="Baptism Request">Baptism Request</option>
                                    <option value="Other">Other</option>
                                </select>
                                @error('subject')
                                    <span class="contact__hero-form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="contact__hero-form-group">
                                <label for="message">Your Message</label>
                                <textarea name="message" id="message" rows="5" placeholder="Tell us how we can help..." required></textarea>
                                @error('message')
                                    <span class="contact__hero-form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn--block">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </form>

                        <p class="contact__hero-form-note">
                            <i class="fas fa-lock"></i> Your information is safe with us.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHATSAPP CTA --}}
    <section class="contact__whatsapp">
        <div class="contact__whatsapp-bg">
            <div class="contact__whatsapp-shape contact__whatsapp-shape--1"></div>
            <div class="contact__whatsapp-shape contact__whatsapp-shape--2"></div>
        </div>
        <div class="contact__whatsapp-tag">WHATSAPP</div>
        <div class="wrap">
            <div class="contact__whatsapp-grid">
                <div class="contact__whatsapp-content">
                    <span class="contact__whatsapp-eyebrow">Quick Connect</span>
                    <h2 class="contact__whatsapp-title">Chat with Us on <span>WhatsApp</span></h2>
                    <p class="contact__whatsapp-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="contact__whatsapp-features">
                        <div class="contact__whatsapp-feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Fast Response</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="contact__whatsapp-feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Personal Connection</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="contact__whatsapp-feature">
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

                <div class="contact__whatsapp-visual">
                    <div class="contact__whatsapp-placeholder">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp Community</span>
                        <small>247+ members · Active now</small>
                        <div class="contact__whatsapp-status">
                            <span class="contact__whatsapp-dot"></span>
                            We're online now
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- LOCATION --}}
    <!-- <section class="contact__location">
        <div class="contact__location-bg">
            <div class="contact__location-shape contact__location-shape--1"></div>
            <div class="contact__location-shape contact__location-shape--2"></div>
        </div>
        <div class="contact__location-tag">LOCATION</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Where to Find Us</span>
                <h2 class="section-header__title">Based in <span>Gauteng</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="contact__location-grid">
                <div class="contact__location-map">
                    <div class="contact__location-placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Gauteng, South Africa</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>

                <div class="contact__location-info">
                    <div class="contact__location-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Phone</strong>
                            <span>+27 (0) 71 461 1401</span>
                        </div>
                    </div>
                    <div class="contact__location-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <span>hello@thecollective.co.za</span>
                        </div>
                    </div>
                    <div class="contact__location-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Response Time</strong>
                            <span>Within 24 hours</span>
                        </div>
                    </div>
                    <div class="contact__location-item">
                        <i class="fas fa-globe-africa"></i>
                        <div>
                            <strong>Location</strong>
                            <span>Gauteng, South Africa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    {{-- COMMUNITY CTA --}}
    <!-- <section class="contact__community">
        <div class="contact__community-bg">
            <div class="contact__community-shape contact__community-shape--1"></div>
            <div class="contact__community-shape contact__community-shape--2"></div>
            <div class="contact__community-shape contact__community-shape--3"></div>
        </div>
        <div class="wrap">
            <div class="contact__community-content reveal" data-delay="100">
                <div class="contact__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="contact__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="contact__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section> -->

</div>

@push('scripts')
    <script src="{{ secure_asset('js/contact.js') }}"></script>
@endpush

@endsection