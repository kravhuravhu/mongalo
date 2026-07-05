@extends('layouts.app')

@section('title', 'The Collective · Baptism')

@section('content')

<div class="baptism-page">

    <!-- ─── HERO ─── -->
    <section class="baptism-hero">
        <div class="baptism-hero__shapes">
            <div class="baptism-hero__shape baptism-hero__shape--1"></div>
            <div class="baptism-hero__shape baptism-hero__shape--2"></div>
            <div class="baptism-hero__shape baptism-hero__shape--3"></div>
        </div>

        <div class="baptism-hero__tag">BAPTISM</div>

        <div class="wrap">
            <div class="baptism-hero__grid">
                <div class="baptism-hero__content">
                    <span class="section__eyebrow">A Step of Faith</span>
                    <h1 class="baptism-hero__title">
                        Ready to Be <br />
                        <span class="baptism-hero__title--gradient">Baptized?</span>
                    </h1>
                    <p class="baptism-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="baptism-hero__buttons">
                        <a href="#baptism-form" class="btn btn--primary">
                            <i class="fas fa-water"></i> Request Baptism
                        </a>
                    </div>
                </div>
                <div class="baptism-hero__image">
                    <div class="baptism-hero__placeholder">
                        <i class="fas fa-water"></i>
                        <span>Baptism</span>
                        <small>A public declaration</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── WHAT IS BAPTISM ─── -->
    <section class="baptism-info" id="baptism-info">
        <div class="baptism-info__tag">TRUTH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Understanding Baptism</span>
                <h2 class="section__title">What Is <span>Baptism?</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="baptism-info__grid">
                <div class="baptism-info__item">
                    <div class="baptism-info__icon"><i class="fas fa-cross"></i></div>
                    <h4>A Declaration of Faith</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-info__item">
                    <div class="baptism-info__icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4>An Act of Obedience</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-info__item">
                    <div class="baptism-info__icon"><i class="fas fa-users"></i></div>
                    <h4>A Public Testimony</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-info__item">
                    <div class="baptism-info__icon"><i class="fas fa-seedling"></i></div>
                    <h4>A New Beginning</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── ARTHUR'S STORY ─── -->
    <section class="baptism-story">
        <div class="baptism-story__tag">STORY</div>

        <div class="wrap">
            <div class="baptism-story__grid">
                <div class="baptism-story__content">
                    <span class="section__eyebrow">My Story</span>
                    <h2 class="baptism-story__title">My <span>Baptism</span> Journey</h2>
                    <p class="baptism-story__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p class="baptism-story__text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <blockquote class="baptism-story__quote">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."
                    </blockquote>
                    <div class="baptism-story__meta">
                        <span><i class="fas fa-calendar-alt"></i> Baptized in 2018</span>
                        <span><i class="fas fa-map-marker-alt"></i> Gauteng, South Africa</span>
                    </div>
                </div>
                <div class="baptism-story__image">
                    <div class="baptism-story__placeholder">
                        <i class="fas fa-water"></i>
                        <span>Arthur's Baptism</span>
                        <small>A moment of transformation</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── BAPTISM REQUEST FORM ─── -->
    <section class="baptism-form" id="baptism-form">
        <div class="baptism-form__tag">REQUEST</div>

        <div class="wrap">
            <div class="baptism-form__grid">
                <div class="baptism-form__info">
                    <span class="section__eyebrow">Take the Step</span>
                    <h2 class="baptism-form__title">Request <span>Baptism</span></h2>
                    <p class="baptism-form__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="baptism-form__features">
                        <span><i class="fas fa-check-circle"></i> One-on-one conversation</span>
                        <span><i class="fas fa-check-circle"></i> No pressure — just truth</span>
                        <span><i class="fas fa-check-circle"></i> Anywhere in Gauteng</span>
                        <span><i class="fas fa-check-circle"></i> Flexible scheduling</span>
                    </div>
                </div>

                <div class="baptism-form__form">
                    @if(session('success'))
                        <div class="baptism-form__success">
                            <i class="fas fa-check-circle"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('baptism.request') }}">
                        @csrf

                        <div class="baptism-form__group">
                            <label for="name">Full Name</label>
                            <input type="text" name="name" id="name" placeholder="Thabo Mokoena" required>
                            @error('name')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism-form__group">
                            <label for="email">Email Address</label>
                            <input type="email" name="email" id="email" placeholder="thabo@example.co.za" required>
                            @error('email')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism-form__group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" name="phone" id="phone" placeholder="+27 71 000 0000" required>
                            @error('phone')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism-form__group">
                            <label for="location">Location</label>
                            <input type="text" name="location" id="location" placeholder="Johannesburg, Pretoria, etc." required>
                            @error('location')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism-form__group">
                            <label for="preferred_date">Preferred Date (Optional)</label>
                            <input type="date" name="preferred_date" id="preferred_date">
                            @error('preferred_date')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="baptism-form__group">
                            <label for="message">Message (Optional)</label>
                            <textarea name="message" id="message" rows="3" placeholder="Tell us a bit about your journey..."></textarea>
                            @error('message')
                                <span class="baptism-form__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn--primary btn--block">
                            <i class="fas fa-water"></i> Request Baptism
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── SCRIPTURE ─── -->
    <section class="baptism-scripture">
        <div class="baptism-scripture__tag">WORD</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Scripture</span>
                <h2 class="section__title">What the Word <span>Says</span></h2>
            </div>

            <div class="baptism-scripture__grid">
                <div class="baptism-scripture__item">
                    <span class="baptism-scripture__ref">Romans 6:4</span>
                    <blockquote class="baptism-scripture__text">
                        "Therefore we were buried with Him through baptism into death, that just as Christ was raised from the dead by the glory of the Father, even so we also should walk in newness of life."
                    </blockquote>
                </div>

                <div class="baptism-scripture__item">
                    <span class="baptism-scripture__ref">Acts 2:38</span>
                    <blockquote class="baptism-scripture__text">
                        "Repent, and let every one of you be baptized in the name of Jesus Christ for the remission of sins; and you shall receive the gift of the Holy Spirit."
                    </blockquote>
                </div>

                <div class="baptism-scripture__item">
                    <span class="baptism-scripture__ref">Mark 16:16</span>
                    <blockquote class="baptism-scripture__text">
                        "He who believes and is baptized will be saved; but he who does not believe will be condemned."
                    </blockquote>
                </div>

                <div class="baptism-scripture__item">
                    <span class="baptism-scripture__ref">Colossians 2:12</span>
                    <blockquote class="baptism-scripture__text">
                        "Buried with Him in baptism, in which you also were raised with Him through faith in the working of God, who raised Him from the dead."
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FAQ ─── -->
    <section class="baptism-faq">
        <div class="baptism-faq__tag">QUESTIONS</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Common Questions</span>
                <h2 class="section__title">Frequently Asked <span>Questions</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="baptism-faq__grid">
                <div class="baptism-faq__item">
                    <h4>Do I need to be a member of a church?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-faq__item">
                    <h4>What if I'm not ready yet?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-faq__item">
                    <h4>Where does the baptism take place?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="baptism-faq__item">
                    <h4>Can I invite friends and family?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="baptism-community">
        <div class="wrap">
            <div class="baptism-community__content">
                <div class="baptism-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="baptism-community__title">Join <span>The Collective</span></h2>
                <p class="baptism-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="baptism-community__benefits">
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