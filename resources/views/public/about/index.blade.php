@extends('layouts.app')

@section('title', 'The Collective · About')

@section('content')

<div class="about">

    <!-- ─── HERO ─── -->
    <section class="about-hero">
        <div class="about-hero__shapes">
            <div class="about-hero__shape about-hero__shape--1"></div>
            <div class="about-hero__shape about-hero__shape--2"></div>
            <div class="about-hero__shape about-hero__shape--3"></div>
        </div>

        <div class="about-hero__tag">ABOUT</div>

        <div class="wrap">
            <div class="about-hero__grid">
                <div class="about-hero__content">
                    <span class="section__eyebrow">Who We Are</span>
                    <h1 class="about-hero__title">
                        A Community of <br />
                        <span class="about-hero__title--gradient">Faith &amp; Purpose</span>
                    </h1>
                    <p class="about-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="about-hero__buttons">
                        <a href="{{ route('books.index') }}" class="btn btn--primary">
                            <i class="fas fa-book"></i> Explore Books
                        </a>
                        <a href="{{ route('community') }}" class="btn btn--outline">
                            <i class="fab fa-whatsapp"></i> Join the Community
                        </a>
                    </div>
                </div>
                <div class="about-hero__image">
                    <div class="about-hero__placeholder">
                        <i class="fas fa-users"></i>
                        <span>The Collective</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── OUR STORY ─── -->
    <section class="story">
        <div class="story__tag">STORY</div>

        <div class="wrap">
            <div class="story__grid">
                <div class="story__content">
                    <span class="section__eyebrow">Our Story</span>
                    <h2 class="story__title">How <span>The Collective</span> Began</h2>
                    <p class="story__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <p class="story__text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                    </p>
                    <div class="story__stats">
                        <div class="story__stat">
                            <span class="story__number">247+</span>
                            <span class="story__label">Community Members</span>
                        </div>
                        <div class="story__stat">
                            <span class="story__number">4</span>
                            <span class="story__label">Books Published</span>
                        </div>
                        <div class="story__stat">
                            <span class="story__number">12+</span>
                            <span class="story__label">Events Hosted</span>
                        </div>
                    </div>
                </div>
                <div class="story__image">
                    <div class="story__placeholder">
                        <i class="fas fa-quote-left"></i>
                        <blockquote>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."
                        </blockquote>
                        <span class="story__attr">— Arthur Mongalo</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── THE FOUR PILLARS ─── -->
    <section class="about-pillars">
        <div class="about-pillars__tag">FAITH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Our Foundation</span>
                <h2 class="section__title">Four Pillars of <span>Our Community</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p>
            </div>

            <div class="about-pillars__grid">
                <div class="about-pillars__card">
                    <div class="about-pillars__num">I</div>
                    <div class="about-pillars__icon"><i class="fas fa-cross"></i></div>
                    <h3 class="about-pillars__name">Faith</h3>
                    <p class="about-pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="about-pillars__card">
                    <div class="about-pillars__num">II</div>
                    <div class="about-pillars__icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="about-pillars__name">Salvation</h3>
                    <p class="about-pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="about-pillars__card">
                    <div class="about-pillars__num">III</div>
                    <div class="about-pillars__icon"><i class="fas fa-water"></i></div>
                    <h3 class="about-pillars__name">Baptism</h3>
                    <p class="about-pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="about-pillars__card">
                    <div class="about-pillars__num">IV</div>
                    <div class="about-pillars__icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="about-pillars__name">Growth</h3>
                    <p class="about-pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── ARTHUR MONGALO ─── -->
    <section class="arthur">
        <div class="arthur__tag">SALVATION</div>

        <div class="wrap">
            <div class="arthur__grid">
                <div class="arthur__image">
                    <div class="arthur__placeholder">
                        <span>Arthur Mongalo</span>
                        <small>Author · Speaker · Storyteller</small>
                    </div>
                </div>
                <div class="arthur__content">
                    <span class="section__eyebrow">Meet Arthur</span>
                    <h2 class="arthur__title">A Man Shaped by <span>Real Life</span></h2>
                    <p class="arthur__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <p class="arthur__text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
                    </p>
                    <blockquote class="arthur__quote">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor."
                    </blockquote>
                    <div class="arthur__buttons">
                        <a href="{{ route('books.index') }}" class="btn btn--primary">
                            <i class="fas fa-book"></i> Explore Books
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn--outline">
                            <i class="fas fa-envelope"></i> Get in Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── TIMELINE ─── -->
    <section class="timeline">
        <div class="timeline__tag">BAPTISM</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Our Journey</span>
                <h2 class="section__title">The <span>Timeline</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="timeline__list">
                <div class="timeline__item">
                    <div class="timeline__dot"></div>
                    <div class="timeline__content">
                        <span class="timeline__year">2020</span>
                        <h4 class="timeline__title">The Beginning</h4>
                        <p class="timeline__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>

                <div class="timeline__item">
                    <div class="timeline__dot"></div>
                    <div class="timeline__content">
                        <span class="timeline__year">2021</span>
                        <h4 class="timeline__title">First Book Released</h4>
                        <p class="timeline__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>

                <div class="timeline__item">
                    <div class="timeline__dot"></div>
                    <div class="timeline__content">
                        <span class="timeline__year">2022</span>
                        <h4 class="timeline__title">Community Launched</h4>
                        <p class="timeline__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>

                <div class="timeline__item">
                    <div class="timeline__dot"></div>
                    <div class="timeline__content">
                        <span class="timeline__year">2023</span>
                        <h4 class="timeline__title">Expansion &amp; Growth</h4>
                        <p class="timeline__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>

                <div class="timeline__item">
                    <div class="timeline__dot"></div>
                    <div class="timeline__content">
                        <span class="timeline__year">2024</span>
                        <h4 class="timeline__title">The Collective Today</h4>
                        <p class="timeline__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── VALUES ─── -->
    <section class="values">
        <div class="values__tag">GROWTH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">What We Believe</span>
                <h2 class="section__title">Our Core <span>Values</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="values__grid">
                <div class="values__card">
                    <div class="values__icon"><i class="fas fa-heart"></i></div>
                    <h4 class="values__name">Love</h4>
                    <p class="values__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="values__card">
                    <div class="values__icon"><i class="fas fa-handshake"></i></div>
                    <h4 class="values__name">Community</h4>
                    <p class="values__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="values__card">
                    <div class="values__icon"><i class="fas fa-book-open"></i></div>
                    <h4 class="values__name">Truth</h4>
                    <p class="values__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>

                <div class="values__card">
                    <div class="values__icon"><i class="fas fa-seedling"></i></div>
                    <h4 class="values__name">Growth</h4>
                    <p class="values__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="about-community">
        <div class="wrap">
            <div class="about-community__content">
                <div class="about-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="about-community__title">Join <span>The Collective</span></h2>
                <p class="about-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="about-community__benefits">
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