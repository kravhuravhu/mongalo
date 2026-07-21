@extends('layouts.app')

@section('title', env('PROJECT_NAME', 'The Collective') . ' · Baptism')

@section('content')

<div class="baptism">

    {{-- BAPTISM FLOATING ORBS --}}
    <div class="baptism__orbs">
        <div class="baptism__orb baptism__orb--1"></div>
        <div class="baptism__orb baptism__orb--2"></div>
        <div class="baptism__orb baptism__orb--3"></div>
        <div class="baptism__orb baptism__orb--4"></div>
        <div class="baptism__orb baptism__orb--5"></div>
    </div>

    {{-- HERO — Water Theme --}}
    <section class="baptism__hero">
        <div class="baptism__hero-bg">
            <div class="baptism__hero-wave baptism__hero-wave--1"></div>
            <div class="baptism__hero-wave baptism__hero-wave--2"></div>
            <div class="baptism__hero-wave baptism__hero-wave--3"></div>
            <div class="baptism__hero-droplet baptism__hero-droplet--1"></div>
            <div class="baptism__hero-droplet baptism__hero-droplet--2"></div>
            <div class="baptism__hero-droplet baptism__hero-droplet--3"></div>
            <div class="baptism__hero-droplet baptism__hero-droplet--4"></div>
            <div class="baptism__hero-droplet baptism__hero-droplet--5"></div>
            <div class="baptism__hero-particle baptism__hero-particle--1"></div>
            <div class="baptism__hero-particle baptism__hero-particle--2"></div>
            <div class="baptism__hero-particle baptism__hero-particle--3"></div>
            <div class="baptism__hero-particle baptism__hero-particle--4"></div>
            <div class="baptism__hero-particle baptism__hero-particle--5"></div>
        </div>
        <div class="baptism__hero-tag">BAPTISM</div>

        <div class="wrap">
            <div class="baptism__hero-grid">
                <div class="baptism__hero-content">
                    <span class="baptism__hero-badge">
                        <i class="fas fa-water"></i> A Step of Faith
                    </span>
                    <h1 class="baptism__hero-title">
                        Ready to Be <br />
                        <span class="baptism__hero-gradient">Baptized?</span>
                    </h1>
                    <p class="baptism__hero-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <div class="baptism__hero-actions">
                        <a href="#baptism-form" class="btn btn--primary btn--lg">
                            <i class="fas fa-water"></i> Request Baptism
                        </a>
                        <a href="#baptism-info" class="btn btn--outline">Learn More</a>
                    </div>
                </div>

                <div class="baptism__hero-visual">
                    <div class="baptism__hero-icon-wrapper">
                        <div class="baptism__hero-icon">
                            <i class="fas fa-water"></i>
                        </div>
                        <div class="baptism__hero-ripples">
                            <span class="baptism__hero-ripple baptism__hero-ripple--1"></span>
                            <span class="baptism__hero-ripple baptism__hero-ripple--2"></span>
                            <span class="baptism__hero-ripple baptism__hero-ripple--3"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- WHAT IS BAPTISM --}}
    <section class="baptism__info" id="baptism-info">
        <div class="baptism__info-bg">
            <div class="baptism__info-shape baptism__info-shape--1"></div>
            <div class="baptism__info-shape baptism__info-shape--2"></div>
        </div>
        <div class="baptism__info-tag">TRUTH</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Understanding Baptism</span>
                <h2 class="section-header__title">What Is <span>Baptism?</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="baptism__info-grid">
                <div class="baptism__info-card">
                    <div class="baptism__info-card-icon"><i class="fas fa-cross"></i></div>
                    <h4 class="baptism__info-card-title">A Declaration of Faith</h4>
                    <p class="baptism__info-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="baptism__info-card">
                    <div class="baptism__info-card-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4 class="baptism__info-card-title">An Act of Obedience</h4>
                    <p class="baptism__info-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="baptism__info-card">
                    <div class="baptism__info-card-icon"><i class="fas fa-users"></i></div>
                    <h4 class="baptism__info-card-title">A Public Testimony</h4>
                    <p class="baptism__info-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="baptism__info-card">
                    <div class="baptism__info-card-icon"><i class="fas fa-seedling"></i></div>
                    <h4 class="baptism__info-card-title">A New Beginning</h4>
                    <p class="baptism__info-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ARTHUR'S STORY --}}
    <section class="baptism__story">
        <div class="baptism__story-bg">
            <div class="baptism__story-shape baptism__story-shape--1"></div>
            <div class="baptism__story-shape baptism__story-shape--2"></div>
        </div>
        <div class="baptism__story-tag">STORY</div>
        <div class="wrap">
            <div class="baptism__story-grid">
                <div class="baptism__story-content">
                    <span class="baptism__story-eyebrow">My Story</span>
                    <h2 class="baptism__story-title">My <span>Baptism</span> Journey</h2>
                    <p class="baptism__story-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p class="baptism__story-text">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="baptism__story-quote">
                        <i class="fas fa-quote-left"></i>
                        <blockquote>"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."</blockquote>
                    </div>
                    <div class="baptism__story-meta">
                        <span><i class="fas fa-calendar-alt"></i> Baptized in 2018</span>
                        <span><i class="fas fa-map-marker-alt"></i> Gauteng, South Africa</span>
                    </div>
                </div>

                <div class="baptism__story-visual">
                    <div class="baptism__story-card">
                        <div class="baptism__story-card-icon"><i class="fas fa-water"></i></div>
                        <div class="baptism__story-card-title">Arthur's Baptism</div>
                        <div class="baptism__story-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
                        <div class="baptism__story-card-line"></div>
                        <div class="baptism__story-card-quote">
                            <i class="fas fa-quote-left"></i>
                            <blockquote>"Lorem ipsum dolor sit amet, consectetur adipiscing elit."</blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STEPS --}}
    <section class="baptism__steps">
        <div class="baptism__steps-bg">
            <div class="baptism__steps-shape baptism__steps-shape--1"></div>
            <div class="baptism__steps-shape baptism__steps-shape--2"></div>
        </div>
        <div class="baptism__steps-tag">STEPS</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Your Journey</span>
                <h2 class="section-header__title">Three Simple <span>Steps</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="baptism__steps-grid">
                <div class="baptism__steps-card">
                    <div class="baptism__steps-number">01</div>
                    <div class="baptism__steps-icon"><i class="fas fa-comments"></i></div>
                    <h4 class="baptism__steps-title">Let's Talk</h4>
                    <p class="baptism__steps-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <div class="baptism__steps-line"></div>
                </div>

                <div class="baptism__steps-card">
                    <div class="baptism__steps-number">02</div>
                    <div class="baptism__steps-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4 class="baptism__steps-title">Prepare</h4>
                    <p class="baptism__steps-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <div class="baptism__steps-line"></div>
                </div>

                <div class="baptism__steps-card">
                    <div class="baptism__steps-number">03</div>
                    <div class="baptism__steps-icon"><i class="fas fa-water"></i></div>
                    <h4 class="baptism__steps-title">Celebrate</h4>
                    <p class="baptism__steps-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <div class="baptism__steps-line"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- SCRIPTURE --}}
    <section class="baptism__scripture">
        <div class="baptism__scripture-bg">
            <div class="baptism__scripture-shape baptism__scripture-shape--1"></div>
            <div class="baptism__scripture-shape baptism__scripture-shape--2"></div>
        </div>
        <div class="baptism__scripture-tag">WORD</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What the Word Says</span>
                <h2 class="section-header__title">Scripture on <span>Baptism</span></h2>
            </div>

            <div class="baptism__scripture-grid">
                <div class="baptism__scripture-item">
                    <span class="baptism__scripture-ref">Romans 6:4</span>
                    <blockquote class="baptism__scripture-text">"Therefore we were buried with Him through baptism into death, that just as Christ was raised from the dead by the glory of the Father, even so we also should walk in newness of life."</blockquote>
                </div>

                <div class="baptism__scripture-item">
                    <span class="baptism__scripture-ref">Acts 2:38</span>
                    <blockquote class="baptism__scripture-text">"Repent, and let every one of you be baptized in the name of Jesus Christ for the remission of sins; and you shall receive the gift of the Holy Spirit."</blockquote>
                </div>

                <div class="baptism__scripture-item">
                    <span class="baptism__scripture-ref">Mark 16:16</span>
                    <blockquote class="baptism__scripture-text">"He who believes and is baptized will be saved; but he who does not believe will be condemned."</blockquote>
                </div>

                <div class="baptism__scripture-item">
                    <span class="baptism__scripture-ref">Colossians 2:12</span>
                    <blockquote class="baptism__scripture-text">"Buried with Him in baptism, in which you also were raised with Him through faith in the working of God, who raised Him from the dead."</blockquote>
                </div>
            </div>
        </div>
    </section>

    {{-- BAPTISM REQUEST FORM --}}
    <section class="baptism__form" id="baptism-form">
        <div class="baptism__form-bg">
            <div class="baptism__form-shape baptism__form-shape--1"></div>
            <div class="baptism__form-shape baptism__form-shape--2"></div>
        </div>
        <div class="baptism__form-tag">REQUEST</div>
        <div class="wrap">
            <div class="baptism__form-grid">
                <div class="baptism__form-info">
                    <span class="baptism__form-eyebrow">Take the Step</span>
                    <h2 class="baptism__form-title">Request <span>Baptism</span></h2>
                    <p class="baptism__form-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                    <div class="baptism__form-features">
                        <span><i class="fas fa-check-circle"></i> One-on-one conversation</span>
                        <span><i class="fas fa-check-circle"></i> No pressure — just truth</span>
                        <span><i class="fas fa-check-circle"></i> Anywhere in Gauteng</span>
                        <span><i class="fas fa-check-circle"></i> Flexible scheduling</span>
                    </div>
                </div>

                <div class="baptism__form-wrapper">
                    @if(session('success'))
                        <div class="baptism__form-success">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('baptism.request') }}" class="baptism__form-form">
                        @csrf

                        <div class="baptism__form-group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                            @error('name')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism__form-group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                            @error('email')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism__form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            @error('phone')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism__form-group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" placeholder="Johannesburg, Pretoria, etc." required>
                            @error('location')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism__form-group">
                            <label for="preferred_date">Preferred Date (Optional)</label>
                            <input type="date" name="preferred_date" id="preferred_date">
                            @error('preferred_date')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism__form-group">
                            <label for="message">Message (Optional)</label>
                            <textarea name="message" id="message" rows="3" placeholder="Tell us a bit about your journey..."></textarea>
                            @error('message')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--block">
                            <i class="fas fa-water"></i> Request Baptism
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="baptism__faq">
        <div class="baptism__faq-bg">
            <div class="baptism__faq-shape baptism__faq-shape--1"></div>
            <div class="baptism__faq-shape baptism__faq-shape--2"></div>
        </div>
        <div class="baptism__faq-tag">FAQ</div>
        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Common Questions</span>
                <h2 class="section-header__title">Frequently Asked <span>Questions</span></h2>
                <p class="section-header__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="baptism__faq-grid">
                <div class="baptism__faq-item">
                    <div class="baptism__faq-item-header">
                        <h4>Do I need to be a member of a church?</h4>
                        <span class="baptism__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="baptism__faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism__faq-item">
                    <div class="baptism__faq-item-header">
                        <h4>What if I'm not ready yet?</h4>
                        <span class="baptism__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="baptism__faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism__faq-item">
                    <div class="baptism__faq-item-header">
                        <h4>Where does the baptism take place?</h4>
                        <span class="baptism__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="baptism__faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism__faq-item">
                    <div class="baptism__faq-item-header">
                        <h4>Can I invite friends and family?</h4>
                        <span class="baptism__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="baptism__faq-answer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- COMMUNITY CTA --}}
    <section class="baptism__community">
        <div class="baptism__community-bg">
            <div class="baptism__community-shape baptism__community-shape--1"></div>
            <div class="baptism__community-shape baptism__community-shape--2"></div>
            <div class="baptism__community-shape baptism__community-shape--3"></div>
        </div>
        <div class="wrap">
            <div class="baptism__community-content">
                <div class="baptism__community-icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="baptism__community-title">Join <span>{{ env('PROJECT_NAME', 'The Collective') }}</span></h2>
                <p class="baptism__community-desc">Join 247+ believers on WhatsApp for daily encouragement and community.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/baptism.js') }}"></script>
@endpush

@endsection