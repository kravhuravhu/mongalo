@extends('layouts.app')

@section('title', 'The Collective · Resources')

@section('content')

<div class="resources-page">

    <!-- ─── HERO ─── -->
    <section class="resources-hero">
        <div class="resources-hero__shapes">
            <div class="resources-hero__shape resources-hero__shape--1"></div>
            <div class="resources-hero__shape resources-hero__shape--2"></div>
            <div class="resources-hero__shape resources-hero__shape--3"></div>
        </div>

        <div class="resources-hero__tag">RESOURCES</div>

        <div class="wrap">
            <div class="resources-hero__grid">
                <div class="resources-hero__content">
                    <span class="section__eyebrow">Free Tools</span>
                    <h1 class="resources-hero__title">
                        Resources to Help <br />
                        <span class="resources-hero__title--gradient">You Grow</span>
                    </h1>
                    <p class="resources-hero__text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                    </p>
                    <div class="resources-hero__buttons">
                        <a href="#resources-grid" class="btn btn--primary">
                            <i class="fas fa-download"></i> Browse Resources
                        </a>
                        <a href="#resources-featured" class="btn btn--outline">
                            <i class="fas fa-star"></i> Featured
                        </a>
                    </div>
                </div>
                <div class="resources-hero__image">
                    <div class="resources-hero__placeholder">
                        <i class="fas fa-box-open"></i>
                        <span>Free Resources</span>
                        <small>Just tools to help you grow.</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── RESOURCES GRID ─── -->
    <section class="resources-grid" id="resources-grid">
        <div class="resources-grid__tag">FREE</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Available Now</span>
                <h2 class="section__title">Free <span>Resources</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="resources-grid__list">
                @forelse($resources as $resource)
                <div class="resources-grid__card">
                    <div class="resources-grid__icon">
                        @if(str_contains($resource->title, 'Gideon'))
                            <i class="fas fa-booklet"></i>
                        @elseif(str_contains($resource->title, 'Chick'))
                            <i class="fas fa-leaf"></i>
                        @elseif(str_contains($resource->title, 'Bible'))
                            <i class="fas fa-bible"></i>
                        @elseif(str_contains($resource->title, 'Prayer'))
                            <i class="fas fa-praying-hands"></i>
                        @else
                            <i class="fas fa-file-pdf"></i>
                        @endif
                    </div>
                    <div class="resources-grid__info">
                        <h4 class="resources-grid__name">{{ $resource->title }}</h4>
                        <p class="resources-grid__desc">{{ $resource->subtitle ?? Str::limit($resource->description, 80) }}</p>
                        <div class="resources-grid__meta">
                            <span class="resources-grid__type">PDF · Free</span>
                            <span class="resources-grid__size">~2.4 MB</span>
                        </div>
                        <a href="#" class="resources-grid__btn">
                            <i class="fas fa-download"></i> Download Now
                        </a>
                    </div>
                </div>
                @empty
                <p class="resources-grid__empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── FEATURED RESOURCE ─── -->
    @if($resources->count() > 0)
    <section class="resources-featured" id="resources-featured">
        <div class="resources-featured__tag">FEATURED</div>

        <div class="wrap">
            <div class="resources-featured__grid">
                <div class="resources-featured__content">
                    <span class="section__eyebrow">Featured Resource</span>
                    <h2 class="resources-featured__title">{{ $resources->first()->title }}</h2>
                    <p class="resources-featured__subtitle">{{ $resources->first()->subtitle ?? 'Essential Resource' }}</p>
                    <p class="resources-featured__desc">{{ $resources->first()->description }}</p>
                    <div class="resources-featured__meta">
                        <span><i class="fas fa-file-pdf"></i> PDF Format</span>
                        <span><i class="fas fa-download"></i> Free Download</span>
                        <span><i class="fas fa-check-circle"></i> No Registration Required</span>
                    </div>
                    <a href="#" class="btn btn--primary">
                        <i class="fas fa-download"></i> Download Now
                    </a>
                </div>
                <div class="resources-featured__image">
                    <div class="resources-featured__placeholder" style="background:{{ $resources->first()->cover_color ?? '#a67c4e' }};">
                        <i class="fas fa-file-pdf"></i>
                        <span>{{ $resources->first()->title }}</span>
                        <small>Free Download</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ─── CATEGORIES ─── -->
    <section class="resources-categories">
        <div class="resources-categories__tag">CATEGORIES</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Browse by Category</span>
                <h2 class="section__title">Explore <span>Collections</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="resources-categories__grid">
                <div class="resources-categories__item">
                    <div class="resources-categories__icon"><i class="fas fa-cross"></i></div>
                    <h4>Faith</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <span class="resources-categories__count">3 resources</span>
                </div>

                <div class="resources-categories__item">
                    <div class="resources-categories__icon"><i class="fas fa-hand-holding-heart"></i></div>
                    <h4>Salvation</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <span class="resources-categories__count">2 resources</span>
                </div>

                <div class="resources-categories__item">
                    <div class="resources-categories__icon"><i class="fas fa-water"></i></div>
                    <h4>Baptism</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <span class="resources-categories__count">4 resources</span>
                </div>

                <div class="resources-categories__item">
                    <div class="resources-categories__icon"><i class="fas fa-seedling"></i></div>
                    <h4>Growth</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <span class="resources-categories__count">5 resources</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── FAQ ─── -->
    <section class="resources-faq">
        <div class="resources-faq__tag">FAQ</div>

        <div class="wrap">
            <div class="section__header">
                <span class="section__eyebrow">Common Questions</span>
                <h2 class="section__title">Frequently Asked <span>Questions</span></h2>
                <p class="section__subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
            </div>

            <div class="resources-faq__grid">
                <div class="resources-faq__item">
                    <h4>Are these really free?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="resources-faq__item">
                    <h4>How do I download them?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="resources-faq__item">
                    <h4>Can I share these with others?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>

                <div class="resources-faq__item">
                    <h4>Will more resources be added?</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="resources-community">
        <div class="wrap">
            <div class="resources-community__content">
                <div class="resources-community__icon"><i class="fab fa-whatsapp"></i></div>
                <h2 class="resources-community__title">Join <span>The Collective</span></h2>
                <p class="resources-community__desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna.</p>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="btn btn--primary">
                    <i class="fab fa-whatsapp"></i> Join on WhatsApp
                </a>
                <div class="resources-community__benefits">
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