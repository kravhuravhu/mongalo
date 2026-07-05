@extends('layouts.app')

@section('title', 'The Collective · Faith · Salvation · Baptism · Growth')

@section('content')

<div class="home">

    <!-- ─── HERO ─── -->
    <section class="hero">
        <div class="hero__shapes">
            <div class="hero__shape hero__shape--1"></div>
            <div class="hero__shape hero__shape--2"></div>
            <div class="hero__shape hero__shape--3"></div>
            <div class="hero__shape hero__shape--4"></div>
        </div>

        <div class="hero__tag">FAITH</div>

        <div class="wrap">
            <div class="hero__grid">
                <div class="hero__left">
                    <span class="hero__badge">A Community of Faith · Growth · Purpose</span>
                    <h1 class="hero__title">
                        Welcome to<br />
                        <span class="hero__title--gradient">The Collective</span>
                    </h1>
                    <p class="hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="hero__buttons">
                        <a href="{{ route('books.index') }}" class="btn btn--primary">
                            <i class="fas fa-book"></i> Explore Books
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn--outline">
                            <i class="fas fa-calendar"></i> Upcoming Events
                        </a>
                    </div>
                    <div class="hero__trust">
                        <div class="hero__avatars">
                            <span class="hero__avatar">NM</span>
                            <span class="hero__avatar">TK</span>
                            <span class="hero__avatar">ZD</span>
                            <span class="hero__avatar">PM</span>
                            <span class="hero__avatar hero__avatar--count">+243</span>
                        </div>
                        <div class="hero__trust-text">
                            <strong>247+ believers</strong>
                            already in our WhatsApp community
                        </div>
                    </div>
                </div>

                <div class="hero__right">
                    <div class="hero__quote">
                        <i class="fas fa-quote-left hero__quote-icon"></i>
                        <blockquote class="hero__quote-text">
                            “I was lost — now I'm found. I was blind — now I see.”
                        </blockquote>
                        <div class="hero__quote-attr">— Arthur Mongalo</div>
                        <div class="hero__pills">
                            <span class="hero__pill"><i class="fas fa-cross"></i> Faith</span>
                            <span class="hero__pill"><i class="fas fa-hand-holding-heart"></i> Salvation</span>
                            <span class="hero__pill"><i class="fas fa-water"></i> Baptism</span>
                            <span class="hero__pill"><i class="fas fa-seedling"></i> Growth</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FOUR PILLARS ─── -->
    <section class="pillars">
        <div class="pillars__tag">SALVATION</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Our Foundation</span>
                <h2 class="section__title">Four Pillars of <span>Faith</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt.</p>
            </div>

            <div class="pillars__grid">
                <div class="pillars__card">
                    <div class="pillars__num">I</div>
                    <div class="pillars__icon"><i class="fas fa-cross"></i></div>
                    <h3 class="pillars__name">Faith</h3>
                    <p class="pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    <a href="#" class="pillars__link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="pillars__card">
                    <div class="pillars__num">II</div>
                    <div class="pillars__icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h3 class="pillars__name">Salvation</h3>
                    <p class="pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    <a href="#" class="pillars__link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="pillars__card">
                    <div class="pillars__num">III</div>
                    <div class="pillars__icon"><i class="fas fa-water"></i></div>
                    <h3 class="pillars__name">Baptism</h3>
                    <p class="pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    <a href="{{ route('baptism') }}" class="pillars__link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="pillars__card">
                    <div class="pillars__num">IV</div>
                    <div class="pillars__icon"><i class="fas fa-seedling"></i></div>
                    <h3 class="pillars__name">Growth</h3>
                    <p class="pillars__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
                    <a href="#" class="pillars__link">Learn More <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FEATURED BOOK ─── -->
    @if($featuredBook)
    <section class="featured">
        <div class="wrap">
            <div class="featured__grid">
                <div class="featured__content">
                    <span class="section__eyebrow">Featured Book</span>
                    <h2 class="featured__title">{{ $featuredBook->title }}</h2>
                    <p class="featured__subtitle">{{ $featuredBook->subtitle }}</p>
                    <p class="featured__desc">{{ Str::limit($featuredBook->description, 200) }}</p>
                    <div class="featured__meta">
                        <span class="featured__price">{{ $featuredBook->price }}</span>
                        <span class="featured__badge">Bestseller</span>
                    </div>
                    <a href="{{ route('books.show', $featuredBook->slug) }}" class="btn btn--primary">
                        <i class="fas fa-book-open"></i> Read More
                    </a>
                </div>
                <div class="featured__cover">
                    <div class="featured__placeholder" style="background:{{ $featuredBook->cover_color }};">
                        {{ $featuredBook->title }}
                        <small>Arthur Mongalo</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ─── BOOKS GRID ─── -->
    <section class="books">
        <div class="books__tag">BAPTISM</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">My Books</span>
                <h2 class="section__title">Words That <span>Change Everything</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="books__grid">
                @forelse($books as $book)
                <div class="books__card">
                    <div class="books__cover" style="background:{{ $book->cover_color }};">
                        {{ $book->title }}
                    </div>
                    <div class="books__info">
                        <h4 class="books__name">{{ $book->title }}</h4>
                        <p class="books__desc">{{ Str::limit($book->subtitle ?? $book->description, 60) }}</p>
                        <div class="books__meta">
                            <span class="books__price">{{ $book->price }}</span>
                            @if($book->is_featured)
                                <span class="books__badge">Featured</span>
                            @endif
                        </div>
                        <a href="{{ route('books.show', $book->slug) }}" class="btn btn--primary btn--sm">View Details</a>
                    </div>
                </div>
                @empty
                <p class="books__empty">No books available yet. Check back soon!</p>
                @endforelse
            </div>

            <div class="books__footer">
                <a href="{{ route('books.index') }}" class="btn btn--outline">View All Books <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- ─── FREE RESOURCES ─── -->
    <section class="resources">
        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Free Resources</span>
                <h2 class="section__title">Tools to Help You <span>Grow</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="resources__grid">
                @forelse($freeResources as $resource)
                <div class="resources__item">
                    <div class="resources__icon"><i class="fas fa-file-pdf"></i></div>
                    <div class="resources__name">{{ $resource->title }}</div>
                    <div class="resources__sub">{{ $resource->subtitle ?? 'Free Download' }}</div>
                    <div class="resources__label"><i class="fas fa-download"></i> Free Download</div>
                </div>
                @empty
                <p class="resources__empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── EVENTS ─── -->
    <section class="events">
        <div class="events__tag">GROWTH</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Upcoming Events</span>
                <h2 class="section__title">Come &amp; <span>Experience It</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="events__list">
                @forelse($upcomingEvents as $event)
                <div class="events__card">
                    <div class="events__date">
                        <span class="events__day">{{ $event->date->format('d') }}</span>
                        <span class="events__month">{{ $event->date->format('M') }}</span>
                    </div>
                    <div class="events__info">
                        <h4 class="events__name">{{ $event->title }}</h4>
                        <p class="events__location"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</p>
                        <p class="events__time"><i class="fas fa-clock"></i> {{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</p>
                    </div>
                    <a href="{{ route('events.show', $event->slug) }}" class="btn btn--primary btn--sm">Register</a>
                </div>
                @empty
                <p class="events__empty">No upcoming events. Check back soon!</p>
                @endforelse
            </div>

            <div class="events__footer">
                <a href="{{ route('events.index') }}" class="btn btn--outline">View All Events <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- ─── BAPTISM CTA ─── -->
    <section class="baptism">
        <div class="wrap">
            <div class="baptism__content">
                <div class="baptism__icon"><i class="fas fa-water"></i></div>
                <h2 class="baptism__title">Ready to be <span>Baptized?</span></h2>
                <p class="baptism__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <a href="{{ route('baptism') }}" class="btn btn--primary">
                    <i class="fas fa-water"></i> Let's Talk About Baptism
                </a>
                <div class="baptism__pills">
                    <span><i class="fas fa-check-circle"></i> One-on-one conversation</span>
                    <span><i class="fas fa-check-circle"></i> No pressure — just truth</span>
                    <span><i class="fas fa-check-circle"></i> Anywhere in Gauteng</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── QUOTES ─── -->
    <section class="quotes">
        <div class="quotes__tag">COMMUNITY</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Scripture That Speaks</span>
                <h2 class="section__title">Words That <span>Shaped Us</span></h2>
            </div>

            <div class="quotes__grid">
                <div class="quotes__item">
                    <span class="quotes__num">I</span>
                    <div>
                        <blockquote class="quotes__text">"For we walk by faith, not by sight."</blockquote>
                        <span class="quotes__ref">— 2 Corinthians 5:7</span>
                    </div>
                </div>
                <div class="quotes__item">
                    <span class="quotes__num">II</span>
                    <div>
                        <blockquote class="quotes__text">"If you confess with your mouth the Lord Jesus and believe in your heart that God has raised Him from the dead, you will be saved."</blockquote>
                        <span class="quotes__ref">— Romans 10:9</span>
                    </div>
                </div>
                <div class="quotes__item">
                    <span class="quotes__num">III</span>
                    <div>
                        <blockquote class="quotes__text">"Therefore we were buried with Him through baptism into death, that just as Christ was raised from the dead by the glory of the Father, even so we also should walk in newness of life."</blockquote>
                        <span class="quotes__ref">— Romans 6:4</span>
                    </div>
                </div>
                <div class="quotes__item">
                    <span class="quotes__num">IV</span>
                    <div>
                        <blockquote class="quotes__text">"But grow in the grace and knowledge of our Lord and Savior Jesus Christ."</blockquote>
                        <span class="quotes__ref">— 2 Peter 3:18</span>
                    </div>
                </div>
                <div class="quotes__item">
                    <span class="quotes__num">V</span>
                    <div>
                        <blockquote class="quotes__text">"I can do all things through Christ who strengthens me."</blockquote>
                        <span class="quotes__ref">— Philippians 4:13</span>
                    </div>
                </div>
                <div class="quotes__item">
                    <span class="quotes__num">VI</span>
                    <div>
                        <blockquote class="quotes__text">"For God so loved the world that He gave His only begotten Son, that whoever believes in Him should not perish but have everlasting life."</blockquote>
                        <span class="quotes__ref">— John 3:16</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="community">
        <div class="wrap">
            <div class="community__content">
                <div class="community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="community__title">Join The <span>Collective</span></h2>
                <p class="community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="community__benefits">
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