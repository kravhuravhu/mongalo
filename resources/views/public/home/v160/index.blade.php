@extends('layouts.v160.app')

@section('title', config('seo.site_name') . ' · ' . config('seo.site_tagline'))

@section('meta_description', 'The official platform of Arthur Mongalo: his testimony, published books and free resources, and the iN Community of believers uniting through Blood, Water and Spirit.')

@section('page-class', 'page-home')

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v160/home.css') }}">
@endpush

@section('content')
    <div class="home" id="home">
        {{-- ─── BACKGROUND ─── --}}
        <div class="home__bg">
            <img src="https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=1920&q=80" alt="Worship crowd with raised hands" class="home__bg-img">
            <div class="home__bg-gradient"></div>
            <div class="home__bg-glow"></div>
            <div class="home__bg-vignette"></div>
        </div>
        <div class="home__dust" id="homeDust"></div>

        {{-- ─── HEADER ─── --}}
        <header class="home__header">
            <a href="{{ route('home') }}" class="home__brand home__fade">
                <!-- <span class="home__brand-mark">AM</span>
                <span class="home__brand-name">Arthur Mongalo</span> -->
            </a>
            <div class="home__platform home__fade">
                <span class="home__platform-dot"></span>
                <span class="home__platform-text">The Official Platform</span>
            </div>
        </header>

        {{-- ─── WATERMARK + CARDS ─── --}}
        <section class="home__pillars">
            <h1 class="home__watermark">iN HIM, iN US</h1>
            <div class="home__grid">
                {{-- ─── CARD 1: MY STORY ─── --}}
                <a href="{{ route('about') }}" class="home__card home__card--story home__reveal">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=900&q=80" alt="Portrait of Arthur Mongalo" class="home__card-img">
                    <div class="home__card-shade"></div>
                    <div class="home__card-sweep"></div>
                    <div class="home__card-top">
                        <span class="home__card-tag">01 / identity</span>
                        <span class="home__card-icon"><i class="fa-solid fa-user"></i></span>
                    </div>
                    <div class="home__card-body">
                        <p class="home__card-kicker">Testimony &amp; Faith</p>
                        <h2 class="home__card-title">My Story</h2>
                        <div class="home__card-rule"></div>
                        <p class="home__card-text">Discover the inspirational journey of Arthur Mongalo, from lost to Born Again in faith.</p>
                        <span class="home__card-cta">Explore Testimony <i class="fa-solid fa-play"></i></span>
                    </div>
                </a>
                {{-- ─── CARD 2: MY BOOKS ─── --}}
                <a href="{{ route('books.index') }}" class="home__card home__card--books home__reveal">
                    <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?auto=format&fit=crop&w=900&q=80" alt="Open book over misty mountains" class="home__card-img">
                    <div class="home__card-shade"></div>
                    <div class="home__card-sweep"></div>
                    <div class="home__card-top">
                        <span class="home__card-tag">02 / publications</span>
                        <span class="home__card-icon"><i class="fa-solid fa-book-open-reader"></i></span>
                    </div>
                    <div class="home__card-body">
                        <p class="home__card-kicker">Literature &amp; Wisdom</p>
                        <h2 class="home__card-title">My Books</h2>
                        <div class="home__card-rule"></div>
                        <ul class="home__card-list">
                            @foreach($books->take(2) as $book)
                                <li><i class="fa-solid fa-book-open"></i>{{ $book->title }}</li>
                            @endforeach
                        </ul>
                        <span class="home__card-cta">Discover Books <i class="fa-solid fa-play"></i></span>
                    </div>
                </a>
                {{-- ─── CARD 3: iN COMMUNITY ─── --}}
                <a href="{{ route('community') }}" class="home__card home__card--community home__reveal">
                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=900&q=80" alt="Worshippers in red light" class="home__card-img">
                    <div class="home__card-shade"></div>
                    <div class="home__card-sweep"></div>
                    <div class="home__card-top">
                        <span class="home__card-tag">03 / fellowship</span>
                        <span class="home__card-icon"><i class="fa-solid fa-people-group"></i></span>
                    </div>
                    <div class="home__card-body">
                        <p class="home__card-kicker">Global Ministry</p>
                        <h2 class="home__card-title">iN Community</h2>
                        <div class="home__card-rule"></div>
                        <p class="home__card-motto">Blood <span>·</span> Water <span>·</span> Spirit</p>
                        <p class="home__card-text home__card-text--tight">Uniting believers worldwide through discipleship</p>
                        <span class="home__card-cta">Join Community <i class="fa-solid fa-play"></i></span>
                    </div>
                </a>
            </div>
        </section>

        {{-- ─── VISION ─── --}}
        <section class="home__vision">
            <p class="home__vision-eyebrow home__reveal">The Vision</p>
            <div class="home__vision-quote-wrap">
                <i class="fa-solid fa-quote-left home__vision-mark home__reveal"></i>
                <blockquote class="home__vision-quote" id="homeQuote">To put the Word in every hand, one booklet, one school, one soul at a time.</blockquote>
            </div>
            <div class="home__vision-divider home__reveal">
                <span class="home__vision-line"></span>
                <i class="fa-solid fa-cross"></i>
                <span class="home__vision-line"></span>
            </div>
        </section>

        {{-- ─── FOOTER ─── --}}
        <footer class="home__footer">
            <p class="home__footer-copy">&copy; {{ date('Y') }} Arthur Mongalo Ministry. All rights reserved.</p>
            <div class="home__footer-social">
                <x-v160.cta-link channel="facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></x-v160.cta-link>
                <x-v160.cta-link channel="instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></x-v160.cta-link>
                <x-v160.cta-link channel="youtube" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></x-v160.cta-link>
                <x-v160.cta-link channel="whatsapp" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></x-v160.cta-link>
            </div>
        </footer>
    </div>
@endsection

@push('scripts')
    <script src="{{ secure_asset('js/v160/home.js') }}"></script>
@endpush