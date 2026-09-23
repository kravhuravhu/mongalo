@extends('layouts.v150.app')

@section('title', env('PROJECT_NAME', 'IN.iN') . ' · Free Resources')

@section('content')

<div class="resources">

    {{-- ─── SECTION 1: HERO ─── --}}
    <section class="resources__hero">
        <div class="resources__hero-bg">
            <img 
                src="https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?w=1920&q=80" 
                alt="Open books on a table"
                class="resources__hero-bg-img"
                loading="eager"
            >
            <div class="resources__hero-overlay"></div>
        </div>

        <div class="wrap">
            <div class="resources__hero-content">
                <h1 class="resources__hero-title">
                    Free <span>Resources</span>
                </h1>

                <p class="resources__hero-subtitle">
                    Booklets, pamphlets, free Bibles and study guides — free forever.
                </p>
            </div>
        </div>

        <div class="resources__hero-count">
            <span class="resources__hero-count-num">{{ $counts['all'] }}</span>
            <span class="resources__hero-count-label">{{ $counts['all'] === 1 ? 'Resource' : 'Resources' }}</span>
        </div>
    </section>

    {{-- ─── SECTION 2: FILTER + GRID ─── --}}
    <section class="resources__main">
        <div class="resources__main-bg">
            <div class="resources__main-shape resources__main-shape--1"></div>
            <div class="resources__main-shape resources__main-shape--2"></div>
        </div>

        <div class="wrap">
            {{-- ─── FILTER PILLS ─── --}}
            <div class="resources__filters">
                <a 
                    href="{{ route('resources', ['cat' => 'all']) }}" 
                    class="resources__filter {{ $category === 'all' ? 'resources__filter--active' : '' }}"
                    data-cat="all"
                >
                    <span>All</span>
                    <span class="resources__filter-count">{{ $counts['all'] }}</span>
                </a>

                @if($counts['booklet'] > 0)
                    <a 
                        href="{{ route('resources', ['cat' => 'booklet']) }}" 
                        class="resources__filter {{ $category === 'booklet' ? 'resources__filter--active' : '' }}"
                        data-cat="booklet"
                    >
                        <span>Booklets</span>
                        <span class="resources__filter-count">{{ $counts['booklet'] }}</span>
                    </a>
                @endif

                @if($counts['pamphlet'] > 0)
                    <a 
                        href="{{ route('resources', ['cat' => 'pamphlet']) }}" 
                        class="resources__filter {{ $category === 'pamphlet' ? 'resources__filter--active' : '' }}"
                        data-cat="pamphlet"
                    >
                        <span>Pamphlets</span>
                        <span class="resources__filter-count">{{ $counts['pamphlet'] }}</span>
                    </a>
                @endif

                @if($counts['bible'] > 0)
                    <a 
                        href="{{ route('resources', ['cat' => 'bible']) }}" 
                        class="resources__filter {{ $category === 'bible' ? 'resources__filter--active' : '' }}"
                        data-cat="bible"
                    >
                        <span>Bibles</span>
                        <span class="resources__filter-count">{{ $counts['bible'] }}</span>
                    </a>
                @endif

                @if($counts['study_guide'] > 0)
                    <a 
                        href="{{ route('resources', ['cat' => 'study_guide']) }}" 
                        class="resources__filter {{ $category === 'study_guide' ? 'resources__filter--active' : '' }}"
                        data-cat="study_guide"
                    >
                        <span>Study Guides</span>
                        <span class="resources__filter-count">{{ $counts['study_guide'] }}</span>
                    </a>
                @endif

                @if($counts['other'] > 0)
                    <a 
                        href="{{ route('resources', ['cat' => 'other']) }}" 
                        class="resources__filter {{ $category === 'other' ? 'resources__filter--active' : '' }}"
                        data-cat="other"
                    >
                        <span>Other</span>
                        <span class="resources__filter-count">{{ $counts['other'] }}</span>
                    </a>
                @endif
            </div>

            {{-- ─── GRID ─── --}}
            @if($resources->count() > 0)
                <div class="resources__grid">
                    @foreach($resources as $resource)
                        <div class="resources__card">
                            {{-- ─── COVER ─── --}}
                            <div class="resources__card-cover">
                                @if($resource->cover_image)
                                    <img 
                                        src="{{ asset('storage/books/covers/' . $resource->cover_image) }}" 
                                        alt="{{ $resource->title }}"
                                        class="resources__card-cover-img"
                                    >
                                @else
                                    <div class="resources__card-cover-placeholder" style="background: {{ $resource->cover_color ?? '#00ff00' }};">
                                        <span>{{ $resource->title }}</span>
                                    </div>
                                @endif

                                <span class="resources__card-category">
                                    {{ $resource->category_label }}
                                </span>

                                <div class="resources__card-cover-shine"></div>
                            </div>

                            {{-- ─── INFO ─── --}}
                            <div class="resources__card-info">
                                <h3 class="resources__card-title">{{ $resource->title }}</h3>

                                @if($resource->subtitle)
                                    <p class="resources__card-subtitle">{{ $resource->subtitle }}</p>
                                @endif

                                <div class="resources__card-meta">
                                    @if($resource->file_type)
                                        <span class="resources__card-format">
                                            <i class="fas fa-file-{{ $resource->file_type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                                            {{ strtoupper($resource->file_type) }}
                                        </span>
                                    @endif

                                    @if($resource->file_size)
                                        <span class="resources__card-size">
                                            <i class="fas fa-hdd"></i>
                                            {{ $resource->file_size }}
                                        </span>
                                    @endif
                                </div>

                                <div class="resources__card-actions">
                                    <a href="{{ route('resources.show', $resource->slug) }}" class="resources__card-btn resources__card-btn--view">
                                        <i class="fas fa-eye" aria-hidden="true"></i>
                                        <span>View</span>
                                    </a>

                                    @if($resource->book_file)
                                        <a href="{{ route('books.download', $resource->id) }}" class="resources__card-btn resources__card-btn--download">
                                            <i class="fas fa-download" aria-hidden="true"></i>
                                            <span>Download</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="resources__empty">
                    <div class="resources__empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="resources__empty-title">No resources yet</h3>
                    <p class="resources__empty-desc">
                        Check back soon — free resources are on the way.
                    </p>
                </div>
            @endif
        </div>
    </section>

    {{-- ─── SECTION 3: HOW IT WORKS STRIP ─── --}}
    <section class="resources__how">
        <div class="resources__how-bg">
            <div class="resources__how-shape resources__how-shape--1"></div>
        </div>

        <div class="wrap">
            <div class="resources__how-grid">
                <div class="resources__how-item">
                    <div class="resources__how-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <h4 class="resources__how-title">Free Forever</h4>
                    <p class="resources__how-desc">No payment, no signup. Just download and read.</p>
                </div>

                <div class="resources__how-item">
                    <div class="resources__how-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h4 class="resources__how-title">Instant Download</h4>
                    <p class="resources__how-desc">Click, download, read — on any device.</p>
                </div>

                <div class="resources__how-item">
                    <div class="resources__how-icon">
                        <i class="fas fa-share-alt"></i>
                    </div>
                    <h4 class="resources__how-title">Share Freely</h4>
                    <p class="resources__how-desc">Pass them on to anyone who needs them.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 4: BACK TO BOOKS CTA ─── --}}
    <section class="resources__books-cta">
        <div class="resources__books-cta-bg">
            <div class="resources__books-cta-shape resources__books-cta-shape--1"></div>
            <div class="resources__books-cta-shape resources__books-cta-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="resources__books-cta-content">
                <div class="resources__books-cta-icon">
                    <i class="fas fa-book"></i>
                </div>

                <h2 class="resources__books-cta-title">
                    Looking for our <span>published books</span>?
                </h2>

                <p class="resources__books-cta-desc">
                    Deep-dive teachings like Divine Identity and My Salvation Companion are available in our bookstore.
                </p>

                <a href="{{ route('books.index') }}" class="btn btn--primary btn--lg">
                    <i class="fas fa-book" aria-hidden="true"></i>
                    <span>Browse Books</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ─── SECTION 5: COMMUNITY CTA ─── --}}
    <section class="resources__community">
        <div class="resources__community-bg">
            <div class="resources__community-shape resources__community-shape--1"></div>
            <div class="resources__community-shape resources__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="resources__community-content">
                <div class="resources__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="resources__community-title">
                    Get new resources <span>as they drop</span>
                </h2>

                <p class="resources__community-desc">
                    Join the community and be the first to know when we add new free downloads.
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
    <script src="{{ secure_asset('js/v150/resources.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/resources.css') }}">
@endpush

@endsection