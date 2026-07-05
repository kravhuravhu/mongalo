@extends('layouts.app')

@section('title', 'The Collective · Community')

@section('content')

<div class="community-page">

    <!-- ─── HERO ─── -->
    <section class="community-hero">
        <div class="community-hero__shapes">
            <div class="community-hero__shape community-hero__shape--1"></div>
            <div class="community-hero__shape community-hero__shape--2"></div>
            <div class="community-hero__shape community-hero__shape--3"></div>
            <div class="community-hero__shape community-hero__shape--4"></div>
        </div>

        <div class="community-hero__tag">JOIN NOW</div>

        <div class="wrap">
            <div class="community-hero__grid">
                <div class="community-hero__content">
                    <span class="section__eyebrow">Online Community</span>
                    <h1 class="community-hero__title">
                        You Belong <br />
                        <span class="community-hero__title--gradient">Here</span>
                    </h1>
                    <p class="community-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <!-- <div class="community-hero__buttons">
                        <a href="#community-join" class="btn btn--primary">
                            <i class="fab fa-whatsapp"></i> Join the Community
                        </a>
                        <a href="#community-benefits" class="btn btn--outline">
                            <i class="fas fa-info-circle"></i> Learn More
                        </a>
                    </div> -->
                    <div class="community-hero__stats">
                        <div class="community-hero__stat">
                            <span class="community-hero__number">247+</span>
                            <span class="community-hero__label">Members</span>
                        </div>
                        <div class="community-hero__stat">
                            <span class="community-hero__number">12+</span>
                            <span class="community-hero__label">Countries</span>
                        </div>
                        <div class="community-hero__stat">
                            <span class="community-hero__number">4+</span>
                            <span class="community-hero__label">Books Shared</span>
                        </div>
                    </div>
                </div>
                <div class="community-hero__image">
                    <div class="community-hero__placeholder">
                        <i class="fas fa-users"></i>
                        <span>The Collective</span>
                        <small>247+ believers growing together</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── BENEFITS ─── -->
    <section class="community-benefits" id="community-benefits">
        <div class="community-benefits__tag">BENEFITS</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">What You Get</span>
                <h2 class="section__title">Community <span>Benefits</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="community-benefits__grid">
                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-praying-hands"></i></div>
                    <h4>Daily Encouragement</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-book"></i></div>
                    <h4>Book Updates</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-water"></i></div>
                    <h4>Baptism Conversations</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-download"></i></div>
                    <h4>Free Resources</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-calendar-alt"></i></div>
                    <h4>Event Alerts</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>

                <div class="community-benefits__item">
                    <div class="community-benefits__icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4>Prayer Support</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── WHATSAPP COMMUNITY ─── -->
    <section class="community-whatsapp" id="community-join">
        <div class="community-whatsapp__tag">COMMUNITY</div>

        <div class="wrap">
            <div class="community-whatsapp__grid">
                <div class="community-whatsapp__info">
                    <span class="section__eyebrow">Join the Conversation</span>
                    <h2 class="community-whatsapp__title">The <span>WhatsApp</span> Community</h2>
                    <p class="community-whatsapp__desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="community-whatsapp__features">
                        <div class="community-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Daily Teachings</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="community-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Event Alerts</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                        <div class="community-whatsapp__feature">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Fellowship</strong>
                                <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="community-whatsapp__mockup">
                    <div class="community-whatsapp__card">
                        <div class="community-whatsapp__header">
                            <div class="community-whatsapp__avatar">C</div>
                            <div>
                                <div class="community-whatsapp__name">The Collective Community</div>
                                <div class="community-whatsapp__status">● 247 members · Active now</div>
                            </div>
                        </div>

                        <div class="community-whatsapp__message community-whatsapp__message--in">
                            <p>Good morning, family. Today's word: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor. 🙏</p>
                            <span class="community-whatsapp__time">Arthur Mongalo · 6:30 AM</span>
                        </div>

                        <div class="community-whatsapp__message community-whatsapp__message--out">
                            <p>This is exactly what I needed this morning. Thank you! 🙌</p>
                            <span class="community-whatsapp__time">Community member · 6:44 AM</span>
                        </div>

                        <div class="community-whatsapp__message community-whatsapp__message--in">
                            <p><strong>Reminder</strong>: Identity in Christ Conference this Saturday, registration link in group description. Bring someone who needs to hear this. 📖</p>
                            <span class="community-whatsapp__time">Arthur Mongalo · 8:02 AM</span>
                        </div>

                        <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="community-whatsapp__join">
                            <i class="fab fa-whatsapp"></i> Join the Community,It's Free
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── TESTIMONIALS ─── -->
    <section class="community-testimonials">
        <div class="community-testimonials__tag">STORIES</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Real Stories</span>
                <h2 class="section__title">What Members Are <span>Saying</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="community-testimonials__grid">
                <div class="community-testimonials__item">
                    <div class="community-testimonials__stars">★★★★★</div>
                    <blockquote class="community-testimonials__text">
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."
                    </blockquote>
                    <div class="community-testimonials__author">
                        <span class="community-testimonials__name">— Nomsa M.</span>
                        <span class="community-testimonials__location">Soweto, Gauteng</span>
                    </div>
                </div>

                <div class="community-testimonials__item">
                    <div class="community-testimonials__stars">★★★★★</div>
                    <blockquote class="community-testimonials__text">
                        "Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur."
                    </blockquote>
                    <div class="community-testimonials__author">
                        <span class="community-testimonials__name">— Thabo K.</span>
                        <span class="community-testimonials__location">Johannesburg, Gauteng</span>
                    </div>
                </div>

                <div class="community-testimonials__item">
                    <div class="community-testimonials__stars">★★★★★</div>
                    <blockquote class="community-testimonials__text">
                        "Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    </blockquote>
                    <div class="community-testimonials__author">
                        <span class="community-testimonials__name">— Palesa M.</span>
                        <span class="community-testimonials__location">Pretoria, Gauteng</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection