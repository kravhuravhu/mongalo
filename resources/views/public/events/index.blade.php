@extends('layouts.app')

@section('title', 'The Collective · Events')

@section('content')

<div class="events-page">

    <!-- ─── HERO ─── -->
    <section class="events-hero">
        <div class="events-hero__shapes">
            <div class="events-hero__shape events-hero__shape--1"></div>
            <div class="events-hero__shape events-hero__shape--2"></div>
            <div class="events-hero__shape events-hero__shape--3"></div>
        </div>

        <div class="events-hero__tag">EVENTS</div>

        <div class="wrap">
            <div class="events-hero__grid">
                <div class="events-hero__content">
                    <span class="section__eyebrow">Upcoming Gatherings</span>
                    <h1 class="events-hero__title">
                        Come &amp; <br />
                        <span class="events-hero__title--gradient">Experience It</span>
                    </h1>
                    <p class="events-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="events-hero__buttons">
                        <a href="#upcoming-events" class="btn btn--primary">
                            <i class="fas fa-calendar"></i> Upcoming Events
                        </a>
                        <a href="#invite-arthur" class="btn btn--outline">
                            <i class="fas fa-handshake"></i> Invite Arthur
                        </a>
                    </div>
                </div>
                <div class="events-hero__image">
                    <div class="events-hero__placeholder">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Join Us</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── UPCOMING EVENTS ─── -->
    <section class="upcoming-events" id="upcoming-events">
        <div class="upcoming-events__tag">GATHER</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Don't Miss Out</span>
                <h2 class="section__title">Upcoming <span>Events</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="upcoming-events__list">
                @forelse($upcomingEvents as $event)
                <div class="upcoming-events__card">
                    <div class="upcoming-events__date">
                        <span class="upcoming-events__day">{{ $event->date->format('d') }}</span>
                        <span class="upcoming-events__month">{{ $event->date->format('M') }}</span>
                        <span class="upcoming-events__year">{{ $event->date->format('Y') }}</span>
                    </div>
                    <div class="upcoming-events__info">
                        <span class="upcoming-events__type">
                            @if(str_contains($event->title, 'Conference'))
                                Conference
                            @elseif(str_contains($event->title, 'Revival'))
                                Revival Night
                            @elseif(str_contains($event->title, 'Gathering'))
                                Gathering
                            @else
                                Event
                            @endif
                        </span>
                        <h3 class="upcoming-events__name">{{ $event->title }}</h3>
                        <p class="upcoming-events__desc">{{ Str::limit($event->description, 120) }}</p>
                        <div class="upcoming-events__meta">
                            <span><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</span>
                            <span><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                            @if($event->capacity)
                                <span><i class="fas fa-users"></i> {{ $event->registrations()->count() }}/{{ $event->capacity }} registered</span>
                            @endif
                        </div>
                    </div>
                    <div class="upcoming-events__actions">
                        <a href="{{ route('events.show', $event->slug) }}" class="btn btn--primary btn--sm">Register Now</a>
                        <a href="#" class="btn btn--outline btn--sm">
                            <i class="fas fa-calendar-plus"></i> Add to Calendar
                        </a>
                    </div>
                </div>
                @empty
                <p class="upcoming-events__empty">No upcoming events. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── PAST EVENTS ─── -->
    @if($pastEvents->count() > 0)
    <section class="past-events">
        <div class="past-events__tag">PAST</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Previous Gatherings</span>
                <h2 class="section__title">Past <span>Events</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
            </div>

            <div class="past-events__grid">
                @foreach($pastEvents as $event)
                <div class="past-events__card">
                    <div class="past-events__date">
                        <span class="past-events__day">{{ $event->date->format('d') }}</span>
                        <span class="past-events__month">{{ $event->date->format('M') }}</span>
                    </div>
                    <div class="past-events__info">
                        <h4 class="past-events__name">{{ $event->title }}</h4>
                        <p class="past-events__location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        <span class="past-events__status">Completed</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- ─── INVITE ARTHUR ─── -->
    <section class="invite-arthur" id="invite-arthur">
        <div class="invite-arthur__tag">INVITE</div>

        <div class="wrap">
            <div class="invite-arthur__grid">
                <div class="invite-arthur__content">
                    <span class="section__eyebrow">Invite Arthur</span>
                    <h2 class="invite-arthur__title">
                        Bring <span>Arthur</span> to Your Event
                    </h2>
                    <p class="invite-arthur__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <p class="invite-arthur__text">
                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    </p>
                    <div class="invite-arthur__features">
                        <span><i class="fas fa-check-circle"></i> Speaking engagements</span>
                        <span><i class="fas fa-check-circle"></i> Book signings</span>
                        <span><i class="fas fa-check-circle"></i> Baptism services</span>
                        <span><i class="fas fa-check-circle"></i> Community gatherings</span>
                    </div>
                    <a href="{{ route('invite') }}" class="btn btn--primary">
                        <i class="fas fa-handshake"></i> Invite Arthur Now
                    </a>
                </div>
                <div class="invite-arthur__image">
                    <div class="invite-arthur__placeholder">
                        <i class="fas fa-handshake"></i>
                        <span>Let's Connect</span>
                        <small>Lorem ipsum dolor sit amet</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── QUOTES ─── -->
    <section class="events-quotes">
        <div class="events-quotes__tag">FAITH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Testimonials</span>
                <h2 class="section__title">What People Are <span>Saying</span></h2>
            </div>

            <div class="events-quotes__grid">
                <div class="events-quotes__item">
                    <div class="events-quotes__stars">★★★★★</div>
                    <blockquote class="events-quotes__text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore."</blockquote>
                    <div class="events-quotes__author">
                        <span class="events-quotes__name">— Thabo M.</span>
                        <span class="events-quotes__location">Johannesburg</span>
                    </div>
                </div>

                <div class="events-quotes__item">
                    <div class="events-quotes__stars">★★★★★</div>
                    <blockquote class="events-quotes__text">"Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat."</blockquote>
                    <div class="events-quotes__author">
                        <span class="events-quotes__name">— Nomsa K.</span>
                        <span class="events-quotes__location">Pretoria</span>
                    </div>
                </div>

                <div class="events-quotes__item">
                    <div class="events-quotes__stars">★★★★★</div>
                    <blockquote class="events-quotes__text">"Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt."</blockquote>
                    <div class="events-quotes__author">
                        <span class="events-quotes__name">— Sipho Z.</span>
                        <span class="events-quotes__location">Soweto</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="events-community">
        <div class="wrap">
            <div class="events-community__content">
                <div class="events-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="events-community__title">Join <span>The Collective</span></h2>
                <p class="events-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="events-community__benefits">
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