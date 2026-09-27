@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Baptism')

@section('content')

@php
    // ─── WHAT BAPTISM MEANS ───
    $meanings = [
        [
            'icon' => 'fa-cross',
            'title' => 'A Public Declaration of Faith',
            'text' => 'Baptism is your public confession that Jesus Christ is Lord, done in front of others as a testimony that your old life is behind you and a new one has begun.'
        ],
        [
            'icon' => 'fa-hand-holding-heart',
            'title' => 'An Act of Obedience',
            'text' => 'Jesus Himself was baptised and commanded His followers to do the same. It is a direct act of obedience to His Word.'
        ],
        [
            'icon' => 'fa-fire',
            'title' => 'Empowered for Service',
            'text' => 'Spirit baptism fills and empowers you for service, equipping every believer to walk in what Arthur calls a life of supernatural power, wisdom and boldness.'
        ],
        [
            'icon' => 'fa-seedling',
            'title' => 'A New Beginning',
            'text' => 'Just as Christ rose from the dead, baptism represents rising into a new life, walking in the renewal of the mind.'
        ]
    ];

    // ─── SCRIPTURES ───
    $scriptures = [
        [
            'reference' => 'Acts 2:38-39',
            'text' => '"Repent, and let every one of you be baptized in the name of Jesus Christ for the remission of sins; and you shall receive the gift of the Holy Spirit."'
        ],
        [
            'reference' => 'Acts 19:1-6',
            'text' => '"And when Paul had laid hands on them, the Holy Spirit came upon them, and they spoke with tongues and prophesied."'
        ],
        [
            'reference' => 'Matthew 3:13-17',
            'text' => '"Permit it to be so now, for thus it is fitting for us to fulfill all righteousness."'
        ],
        [
            'reference' => 'Acts 8:36-39',
            'text' => '"Both Philip and the eunuch went down into the water, and he baptized him."'
        ]
    ];

    // ─── FAQ ───
    $faqs = [
        [
            'question' => 'Do I need to be a member of a church?',
            'answer' => 'No. Baptism is available to anyone who believes in Jesus Christ, regardless of which church you attend or if you attend one at all.'
        ],
        [
            'question' => 'What if I\'m not ready yet?',
            'answer' => 'That is completely fine. Reaching out does not commit you to anything. We are happy to talk, answer questions and let you decide in your own time.'
        ],
        [
            'question' => 'Where does the baptism take place?',
            'answer' => 'Baptism happens as part of the planned three-day camp. Reach out to express interest or ask a question, dates and location will be confirmed directly with you, nothing is booked until then.'
        ]
    ];
@endphp

<div class="baptism">

    {{-- ─── SECTION 1: HERO - ARTHUR'S STORY ─── --}}
    <section class="baptism__hero">
        <div class="baptism__hero-bg">
            <div class="baptism__hero-gradient"></div>

            {{-- ─── ARTHUR IMAGE (ATMOSPHERIC) ─── --}}
            <div class="baptism__hero-image">
                <img 
                    src="{{secure_asset('/images/arthur-mongalo-baptism-portait.jpg')}}" 
                    alt="Man standing in water at sunset"
                    class="baptism__hero-image-img"
                    loading="eager"
                >
            </div>

            <canvas class="baptism__hero-canvas" id="baptismHeroCanvas"></canvas>
        </div>

        {{-- ─── HERO CONTENT ─── --}}
        <div class="wrap">
            <div class="baptism__hero-content">
                <span class="baptism__hero-eyebrow">
                    <span class="baptism__hero-eyebrow-line"></span>
                    Arthur's Baptism
                </span>

                <h1 class="baptism__hero-title">
                    I <span>walked</span> it looking for assurance.<br>
                    You don't <span>have to walk it alone.</span>
                </h1>

                <div class="baptism__hero-story">
                    <p class="baptism__hero-text">
                        I responded to the call to accept Christ more than once. I was baptised in water in 1999, and again sometime between 2002 and 2004. My experience of Holy Spirit baptism also deeply shaped my life.
                    </p>
                    <p class="baptism__hero-text">
                        This ministry is for people like me, Christians seeking assurance or baptism, and believers who want to serve but do not know where to begin.
                    </p>
                </div>

                <div class="baptism__hero-actions">
                    <a href="#contact" class="btn btn--primary btn--lg">
                        <i class="fas fa-water" aria-hidden="true"></i>
                        <span>Register Your Interest</span>
                    </a>
                    <a href="tel:+27714611401" class="baptism__hero-call">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                        <span>Call Us: +27 71 461 1401</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- ─── WAVE DIVIDER ─── --}}
        <div class="baptism__hero-wave">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,50 C240,100 480,0 720,50 C960,100 1200,0 1440,50 L1440,100 L0,100 Z" fill="#F5F0E8"></path>
            </svg>
        </div>
    </section>

    {{-- ─── SECTION 2: THE TWO BAPTISMS ─── --}}
    <section class="baptism__two">
        <div class="baptism__two-bg">
            <div class="baptism__two-shape baptism__two-shape--1"></div>
            <div class="baptism__two-shape baptism__two-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Two Baptisms. One Transformation.</span>
                <h2 class="section-header__title">Water <span>and</span> Spirit</h2>
                <p class="section-header__subtitle">
                    "No one can enter God's kingdom unless they are born of water and the Spirit." - John 3:5
                </p>
            </div>

            <div class="baptism__two-grid">

                {{-- ─── WATER BAPTISM ─── --}}
                <div class="baptism__two-card baptism__two-card--water">
                    <div class="baptism__two-card-bg">
                        <div class="baptism__two-card-bubble baptism__two-card-bubble--1"></div>
                        <div class="baptism__two-card-bubble baptism__two-card-bubble--2"></div>
                        <div class="baptism__two-card-bubble baptism__two-card-bubble--3"></div>
                        <div class="baptism__two-card-bubble baptism__two-card-bubble--4"></div>
                    </div>

                    <div class="baptism__two-card-content">
                        <div class="baptism__two-card-icon baptism__two-card-icon--water">
                            <i class="fas fa-water" aria-hidden="true"></i>
                        </div>

                        <h3 class="baptism__two-card-title">Water Baptism</h3>

                        <p class="baptism__two-card-desc">
                            Water baptism is a physical act, full immersion in water. It represents death to the old life and resurrection into the new, a public declaration that Jesus is Lord.
                        </p>

                        <blockquote class="baptism__two-card-quote">
                            <i class="fas fa-quote-left" aria-hidden="true"></i>
                            "See, here is water. What hinders me from being baptised?"
                            - Acts 8:36
                        </blockquote>
                    </div>
                </div>

                {{-- ─── SPIRIT BAPTISM ─── --}}
                <div class="baptism__two-card baptism__two-card--spirit">
                    <div class="baptism__two-card-bg">
                        <div class="baptism__two-card-flame baptism__two-card-flame--1"></div>
                        <div class="baptism__two-card-flame baptism__two-card-flame--2"></div>
                        <div class="baptism__two-card-flame baptism__two-card-flame--3"></div>
                    </div>

                    <div class="baptism__two-card-content">
                        <div class="baptism__two-card-icon baptism__two-card-icon--spirit">
                            <i class="fas fa-fire" aria-hidden="true"></i>
                        </div>

                        <h3 class="baptism__two-card-title">Spirit Baptism</h3>

                        <p class="baptism__two-card-desc">
                            The Holy Spirit fills and empowers you for service, equipping every believer to walk in what Arthur calls a life of supernatural power, wisdom and boldness.
                        </p>

                        <blockquote class="baptism__two-card-quote">
                            <i class="fas fa-quote-left" aria-hidden="true"></i>
                            "Paul had laid hands on them, the Holy Spirit came upon them, and they spoke with tongues and prophesied."
                            - Acts 19:6
                        </blockquote>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── SECTION 3: WHAT BAPTISM MEANS ─── --}}
    <section class="baptism__meaning">
        <div class="baptism__meaning-bg">
            <div class="baptism__meaning-shape baptism__meaning-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Understanding Baptism</span>
                <h2 class="section-header__title">What Baptism <span>Means</span></h2>
            </div>

            <div class="baptism__meaning-grid">
                @foreach($meanings as $item)
                    <div class="baptism__meaning-card">
                        <div class="baptism__meaning-icon">
                            <i class="fas {{ $item['icon'] }}"></i>
                        </div>
                        <h4 class="baptism__meaning-title">{{ $item['title'] }}</h4>
                        <p class="baptism__meaning-text">{{ $item['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: SCRIPTURES ─── --}}
    <section class="baptism__scriptures">
        <div class="baptism__scriptures-bg">
            <div class="baptism__scriptures-shape baptism__scriptures-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">What the Word Says</span>
                <h2 class="section-header__title">Scripture on <span>Baptism</span></h2>
            </div>

            <div class="baptism__scriptures-grid">
                @foreach($scriptures as $scripture)
                    <div class="baptism__scriptures-card">
                        <span class="baptism__scriptures-ref">{{ $scripture['reference'] }}</span>
                        <blockquote class="baptism__scriptures-text">
                            {{ $scripture['text'] }}
                        </blockquote>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: STEPS ─── --}}
    <section class="baptism__steps">
        <div class="baptism__steps-bg">
            <div class="baptism__steps-shape baptism__steps-shape--1"></div>
            <div class="baptism__steps-shape baptism__steps-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Your Journey</span>
                <h2 class="section-header__title">Three Simple <span>Steps</span></h2>
                <p class="section-header__subtitle">
                    Getting started begins with a conversation. Baptism itself happens as part of the planned three-day camp, teaching, water baptism and Spirit baptism together.
                </p>
            </div>

            <div class="baptism__steps-grid">
                <div class="baptism__steps-card">
                    <span class="baptism__steps-num">01</span>
                    <div class="baptism__steps-icon">
                        <i class="fas fa-comments" aria-hidden="true"></i>
                    </div>
                    <h4 class="baptism__steps-title">Let's Talk</h4>
                    <p class="baptism__steps-desc">
                        Reach out through the form or a call. We'll have an honest, no-pressure conversation about your faith and readiness.
                    </p>
                    <div class="baptism__steps-line"></div>
                </div>

                <div class="baptism__steps-card">
                    <span class="baptism__steps-num">02</span>
                    <div class="baptism__steps-icon">
                        <i class="fas fa-hand-holding-heart" aria-hidden="true"></i>
                    </div>
                    <h4 class="baptism__steps-title">Prepare</h4>
                    <p class="baptism__steps-desc">
                        We'll talk through what taking part looks like, including the planned camp, and what happens next.
                    </p>
                    <div class="baptism__steps-line"></div>
                </div>

                <div class="baptism__steps-card">
                    <span class="baptism__steps-num">03</span>
                    <div class="baptism__steps-icon">
                        <i class="fas fa-water" aria-hidden="true"></i>
                    </div>
                    <h4 class="baptism__steps-title">Celebrate</h4>
                    <p class="baptism__steps-desc">
                        Being baptised is worth celebrating. It marks a real, public step in your faith.
                    </p>
                    <div class="baptism__steps-line"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 6: CALL US OR FILL THE FORM ─── --}}
    <section class="baptism__contact" id="contact">
        <div class="baptism__contact-bg">
            <div class="baptism__contact-shape baptism__contact-shape--1"></div>
            <div class="baptism__contact-shape baptism__contact-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Reach Out</span>
                <h2 class="section-header__title">Call Us <span>or</span> Fill the Form</h2>
                <p class="section-header__subtitle">
                    Whichever feels right, a call or a form. Both work.
                </p>
            </div>

            <div class="baptism__contact-grid">

                {{-- ─── CALL US ─── --}}
                <div class="baptism__contact-call">
                    <span class="baptism__contact-call-eyebrow">Prefer to Talk?</span>
                    <h3 class="baptism__contact-call-title">
                        Let's have a<br>
                        <span>real conversation.</span>
                    </h3>
                    <p class="baptism__contact-call-desc">
                        No forms, no pressure. Reach out directly and we'll talk through baptism, your questions, and next steps.
                    </p>

                    <div class="baptism__contact-call-actions">
                        <a href="tel:+27714611401" class="baptism__contact-call-btn baptism__contact-call-btn--phone">
                            <div class="baptism__contact-call-btn-icon">
                                <i class="fas fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="baptism__contact-call-btn-text">
                                <span class="baptism__contact-call-btn-label">Call Us</span>
                                <span class="baptism__contact-call-btn-value">+27 71 461 1401</span>
                            </div>
                        </a>

                        <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="baptism__contact-call-btn baptism__contact-call-btn--whatsapp">
                            <div class="baptism__contact-call-btn-icon">
                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            </div>
                            <div class="baptism__contact-call-btn-text">
                                <span class="baptism__contact-call-btn-label">WhatsApp</span>
                                <span class="baptism__contact-call-btn-value">Reach us on WhatsApp</span>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- ─── FORM ─── --}}
                <div class="baptism__contact-form-wrap">
                    <div class="baptism__contact-form-header">
                        <h3 class="baptism__contact-form-title">Register Your Interest</h3>
                        <p class="baptism__contact-form-subtitle">
                            Fill in your details and we'll reach out soon.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('baptism.request') }}" class="baptism__contact-form form-loading">
                        @csrf

                        <div class="baptism__form-row">
                            <div class="baptism__form-group">
                                <label for="name">Full Name <span class="baptism__form-required">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Your full name" value="{{ old('name') }}" required>
                                @error('name')
                                    <span class="baptism__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="baptism__form-group">
                                <label for="email">Email Address <span class="baptism__form-required">*</span></label>
                                <input type="email" name="email" id="email" placeholder="your@email.com" value="{{ old('email') }}" required>
                                @error('email')
                                    <span class="baptism__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="baptism__form-row">
                            <div class="baptism__form-group">
                                <label for="phone">Phone Number <span class="baptism__form-required">*</span></label>
                                <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <span class="baptism__form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="baptism__form-group">
                                <label for="location">Location <span class="baptism__form-required">*</span></label>
                                <input type="text" name="location" id="location" placeholder="City or area" value="{{ old('location') }}" required>
                                @error('location')
                                    <span class="baptism__form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="baptism__form-group">
                            <label for="message">Message (Optional)</label>
                            <textarea name="message" id="message" rows="4" placeholder="Tell us a bit about your journey...">{{ old('message') }}</textarea>
                            @error('message')
                                <span class="baptism__form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-water" aria-hidden="true"></i>
                            <span>Register Your Interest</span>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- ─── SECTION 7: FAQ ─── --}}
    <section class="baptism__faq">
        <div class="baptism__faq-bg">
            <div class="baptism__faq-shape baptism__faq-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="section-header">
                <span class="section-header__eyebrow">Common Questions</span>
                <h2 class="section-header__title">Frequently Asked <span>Questions</span></h2>
            </div>

            <div class="baptism__faq-list">
                @foreach($faqs as $index => $faq)
                    <div class="baptism__faq-item {{ $index === 0 ? 'baptism__faq-item--open' : '' }}">
                        <button type="button" class="baptism__faq-question" onclick="toggleBaptismFaq(this)">
                            <span class="baptism__faq-question-text">{{ $faq['question'] }}</span>
                            <span class="baptism__faq-question-icon">
                                <i class="fas fa-{{ $index === 0 ? 'minus' : 'plus' }}" aria-hidden="true"></i>
                            </span>
                        </button>
                        <div class="baptism__faq-answer" style="{{ $index === 0 ? 'display: block;' : '' }}">
                            <p>{{ $faq['answer'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ─── SECTION 8: COMMUNITY CTA ─── --}}
    <section class="baptism__community">
        <div class="baptism__community-bg">
            <div class="baptism__community-shape baptism__community-shape--1"></div>
            <div class="baptism__community-shape baptism__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="baptism__community-content">
                <div class="baptism__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="baptism__community-title">
                    Join the <span>community</span>
                </h2>

                <p class="baptism__community-desc">
                    Be among the first to connect with believers walking through the same journey.
                </p>

                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary btn--lg">
                    <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    <span>Join on WhatsApp</span>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/v150/baptism.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/baptism.css') }}">
@endpush

@endsection