@extends('layouts.app')

@section('title', 'The Collective · Resources')

@section('content')

<div class="resources">

    <!-- ─── HERO ─── -->
    <section class="resources__hero">
        <div class="resources__hero-bg">
            <div class="resources__hero-shape resources__hero-shape--1"></div>
            <div class="resources__hero-shape resources__hero-shape--2"></div>
            <div class="resources__hero-shape resources__hero-shape--3"></div>
        </div>

        <div class="wrap">
            <div class="resources__hero-container">
                <div class="resources__hero-content">
                    <span class="resources__hero-badge">
                        <i class="fas fa-box-open" aria-hidden="true"></i>
                        Free Tools
                    </span>
                    <h1 class="resources__hero-title">
                        Resources to Help
                        <span class="resources__hero-title-highlight">You Grow</span>
                    </h1>
                    <p class="resources__hero-text">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <div class="resources__hero-actions">
                        <a href="#resources-grid" class="resources__hero-btn resources__hero-btn--primary">
                            <span>Browse Resources</span>
                            <i class="fas fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        <a href="#resources-featured" class="resources__hero-btn resources__hero-btn--secondary">
                            <i class="fas fa-star" aria-hidden="true"></i>
                            <span>Featured</span>
                        </a>
                    </div>
                </div>

                <div class="resources__hero-visual">
                    <div class="resources__hero-box">
                        <div class="resources__hero-box-inner">
                            <i class="fas fa-file-pdf"></i>
                            <span class="resources__hero-box-title">Resource Library</span>
                            <span class="resources__hero-box-count">{{ $resources->count() }} Resources</span>
                        </div>
                        <div class="resources__hero-box-shadows">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── CATEGORIES ─── -->
    <section class="resources__categories">
        <div class="wrap">
            <div class="resources__categories-list">
                <button class="resources__categories-pill resources__categories-pill--active" data-category="all">
                    <i class="fas fa-th-large"></i>
                    All
                </button>
                <button class="resources__categories-pill" data-category="faith">
                    <i class="fas fa-cross"></i>
                    Faith
                </button>
                <button class="resources__categories-pill" data-category="salvation">
                    <i class="fas fa-hand-holding-heart"></i>
                    Salvation
                </button>
                <button class="resources__categories-pill" data-category="baptism">
                    <i class="fas fa-water"></i>
                    Baptism
                </button>
                <button class="resources__categories-pill" data-category="growth">
                    <i class="fas fa-seedling"></i>
                    Growth
                </button>
                <button class="resources__categories-pill" data-category="guides">
                    <i class="fas fa-compass"></i>
                    Guides
                </button>
            </div>
        </div>
    </section>

    <!-- ─── FEATURED RESOURCE ─── -->
    @if($resources->isNotEmpty())
    <section class="resources__featured" id="resources-featured">
        <div class="resources__featured-bg">
            <span class="resources__featured-tag">FEATURED</span>
            <div class="resources__featured-shape resources__featured-shape--1"></div>
            <div class="resources__featured-shape resources__featured-shape--2"></div>
        </div>

        @php $featured = $resources->first(); @endphp
        <div class="wrap">
            <div class="resources__featured-container">
                <div class="resources__featured-content">
                    <span class="resources__featured-eyebrow">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        Featured Resource
                    </span>
                    <h2 class="resources__featured-title">{{ $featured->title }}</h2>
                    <p class="resources__featured-subtitle">{{ $featured->subtitle ?? 'Essential Resource' }}</p>
                    <p class="resources__featured-desc">
                        {{ $featured->description ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }}
                    </p>
                    <div class="resources__featured-meta">
                        <span class="resources__featured-meta-item">
                            <i class="fas fa-file-pdf"></i>
                            PDF Format
                        </span>
                        <span class="resources__featured-meta-item">
                            <i class="fas fa-download"></i>
                            Free Download
                        </span>
                        <span class="resources__featured-meta-item">
                            <i class="fas fa-check-circle"></i>
                            No Registration
                        </span>
                    </div>
                    <a href="#" class="resources__featured-btn">
                        <i class="fas fa-download"></i>
                        <span>Download Now</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

                <div class="resources__featured-visual">
                    <div class="resources__featured-card" style="background:{{ $featured->cover_color ?? '#a67c4e' }};">
                        <i class="fas fa-file-pdf"></i>
                        <span class="resources__featured-card-title">{{ $featured->title }}</span>
                        <span class="resources__featured-card-badge">Free</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- ─── RESOURCES GRID ─── -->
    <section class="resources__grid" id="resources-grid">
        <div class="resources__grid-bg">
            <span class="resources__grid-tag">LIBRARY</span>
        </div>

        <div class="wrap">
            <div class="resources__grid-header">
                <span class="resources__grid-eyebrow">Available Now</span>
                <h2 class="resources__grid-title">Free <span>Resources</span></h2>
                <p class="resources__grid-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="resources__grid-list">
                @forelse($resources as $index => $resource)
                <div class="resources__grid-card" data-category="{{ $resource->category ?? 'faith' }}" style="animation-delay: {{ $index * 0.06 }}s;">
                    <div class="resources__grid-icon">
                        @if(($resource->category ?? '') == 'baptism')
                            <i class="fas fa-water"></i>
                        @elseif(($resource->category ?? '') == 'salvation')
                            <i class="fas fa-hand-holding-heart"></i>
                        @elseif(($resource->category ?? '') == 'growth')
                            <i class="fas fa-seedling"></i>
                        @elseif(($resource->category ?? '') == 'guides')
                            <i class="fas fa-compass"></i>
                        @else
                            <i class="fas fa-file-pdf"></i>
                        @endif
                    </div>
                    <div class="resources__grid-info">
                        <h4 class="resources__grid-name">{{ $resource->title }}</h4>
                        <p class="resources__grid-desc">
                            {{ $resource->subtitle ?? 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.' }}
                        </p>
                        <div class="resources__grid-meta">
                            <span class="resources__grid-type">
                                <i class="fas fa-file-pdf"></i>
                                PDF
                            </span>
                            <span class="resources__grid-size">~2.4 MB</span>
                            <span class="resources__grid-category">
                                {{ ucfirst($resource->category ?? 'Faith') }}
                            </span>
                        </div>
                        <a href="#" class="resources__grid-btn">
                            <i class="fas fa-download"></i>
                            <span>Download</span>
                        </a>
                    </div>
                </div>
                @empty
                <p class="resources__grid-empty">Free resources coming soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ─── FAQ ─── -->
    <section class="resources__faq">
        <div class="resources__faq-bg">
            <span class="resources__faq-tag">FAQ</span>
        </div>

        <div class="wrap">
            <div class="resources__faq-header">
                <span class="resources__faq-eyebrow">Common Questions</span>
                <h2 class="resources__faq-title">Frequently Asked <span>Questions</span></h2>
                <p class="resources__faq-subtitle">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </p>
            </div>

            <div class="resources__faq-grid">
                <div class="resources__faq-item">
                    <div class="resources__faq-item-header">
                        <h4>Are these really free?</h4>
                        <span class="resources__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="resources__faq-answer">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <div class="resources__faq-item">
                    <div class="resources__faq-item-header">
                        <h4>How do I download them?</h4>
                        <span class="resources__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="resources__faq-answer">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <div class="resources__faq-item">
                    <div class="resources__faq-item-header">
                        <h4>Can I share these with others?</h4>
                        <span class="resources__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="resources__faq-answer">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <div class="resources__faq-item">
                    <div class="resources__faq-item-header">
                        <h4>Will more resources be added?</h4>
                        <span class="resources__faq-toggle">
                            <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    <p class="resources__faq-answer">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ─── COMMUNITY CTA ─── -->
    <section class="resources__community">
        <div class="resources__community-bg">
            <span class="resources__community-tag">COMMUNITY</span>
        </div>

        <div class="wrap">
            <div class="resources__community-content">
                <div class="resources__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>
                <h2 class="resources__community-title">Join <span>The Collective</span></h2>
                <p class="resources__community-desc">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.
                </p>
                <div class="resources__community-benefits">
                    <span><i class="fas fa-check-circle"></i> Daily encouragement</span>
                    <span><i class="fas fa-check-circle"></i> Book updates</span>
                    <span><i class="fas fa-check-circle"></i> Baptism conversations</span>
                    <span><i class="fas fa-check-circle"></i> Free resources</span>
                </div>
                <a href="{{ config('app.whatsapp_invite_url', '#') }}" target="_blank" class="resources__community-btn">
                    <i class="fab fa-whatsapp"></i>
                    <span>Join on WhatsApp</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

</div>

@push('scripts')
    <script src="{{ secure_asset('js/resources.js') }}"></script>
@endpush

@endsection