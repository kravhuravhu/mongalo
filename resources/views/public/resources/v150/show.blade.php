@extends('layouts.v150.app')

@section('title', $resource->title . ' · ' . env('PROJECT_NAME', 'IN.iN'))

@section('content')

<div class="resource-detail">

    {{-- ─── HERO — SPLIT LAYOUT ─── --}}
    <section class="resource-detail__hero">
        <div class="resource-detail__hero-bg">
            <div class="resource-detail__hero-shape resource-detail__hero-shape--1"></div>
            <div class="resource-detail__hero-shape resource-detail__hero-shape--2"></div>
        </div>

        <div class="wrap">
            {{-- ─── BREADCRUMB ─── --}}
            <div class="resource-detail__breadcrumb">
                <a href="{{ route('resources') }}">Free Resources</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $resource->title }}</span>
            </div>

            <div class="resource-detail__hero-grid">
                {{-- ─── COVER LEFT ─── --}}
                <div class="resource-detail__cover">
                    <div class="resource-detail__cover-book">
                        @if($resource->cover_image)
                            <img 
                                src="{{ asset('storage/books/covers/' . $resource->cover_image) }}" 
                                alt="{{ $resource->title }}"
                                class="resource-detail__cover-img"
                            >
                        @else
                            <div class="resource-detail__cover-placeholder" style="background: {{ $resource->cover_color ?? '#00ff00' }};">
                                <span>{{ $resource->title }}</span>
                            </div>
                        @endif

                        <div class="resource-detail__cover-spine"></div>
                        <div class="resource-detail__cover-shine"></div>
                    </div>
                </div>

                {{-- ─── INFO RIGHT ─── --}}
                <div class="resource-detail__info">
                    <span class="resource-detail__category">
                        <i class="fas fa-tag"></i>
                        {{ $resource->category_label }}
                    </span>

                    <h1 class="resource-detail__title">{{ $resource->title }}</h1>

                    @if($resource->subtitle)
                        <p class="resource-detail__subtitle">{{ $resource->subtitle }}</p>
                    @endif

                    <p class="resource-detail__desc">{{ $resource->description }}</p>

                    <div class="resource-detail__meta">
                        <span class="resource-detail__meta-item">
                            <i class="fas fa-gift"></i>
                            Free
                        </span>

                        @if($resource->file_type)
                            <span class="resource-detail__meta-item">
                                <i class="fas fa-file-{{ $resource->file_type === 'pdf' ? 'pdf' : 'alt' }}"></i>
                                {{ strtoupper($resource->file_type) }}
                            </span>
                        @endif

                        @if($resource->file_size)
                            <span class="resource-detail__meta-item">
                                <i class="fas fa-hdd"></i>
                                {{ $resource->file_size }}
                            </span>
                        @endif

                        @if($resource->download_count > 0)
                            <span class="resource-detail__meta-item">
                                <i class="fas fa-download"></i>
                                {{ number_format($resource->download_count) }} downloads
                            </span>
                        @endif
                    </div>

                    <div class="resource-detail__actions">
                        @if($resource->book_file)
                            <a href="{{ route('books.download', $resource->id) }}" class="btn btn--primary btn--lg">
                                <i class="fas fa-download" aria-hidden="true"></i>
                                <span>Download Free</span>
                            </a>
                        @else
                            <div class="resource-detail__unavailable">
                                <i class="fas fa-info-circle"></i>
                                File coming soon
                            </div>
                        @endif

                        <a href="{{ route('resources') }}" class="btn btn--outline btn--lg">
                            <i class="fas fa-arrow-left" aria-hidden="true"></i>
                            <span>Back to Resources</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ─── RELATED RESOURCES ─── --}}
    @if($relatedResources->count() > 0)
        <section class="resource-detail__related">
            <div class="resource-detail__related-bg">
                <div class="resource-detail__related-shape resource-detail__related-shape--1"></div>
            </div>

            <div class="wrap">
                <div class="section-header">
                    <span class="section-header__eyebrow">More Like This</span>
                    <h2 class="section-header__title">Related <span>Resources</span></h2>
                </div>

                <div class="resource-detail__related-grid">
                    @foreach($relatedResources as $related)
                        <div class="resource-detail__related-card">
                            <div class="resource-detail__related-cover">
                                @if($related->cover_image)
                                    <img 
                                        src="{{ asset('storage/books/covers/' . $related->cover_image) }}" 
                                        alt="{{ $related->title }}"
                                    >
                                @else
                                    <div class="resource-detail__related-cover-placeholder" style="background: {{ $related->cover_color ?? '#00ff00' }};">
                                        <span>{{ $related->title }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="resource-detail__related-info">
                                <h4 class="resource-detail__related-title">{{ $related->title }}</h4>
                                <span class="resource-detail__related-category">{{ $related->category_label }}</span>

                                <a href="{{ route('resources.show', $related->slug) }}" class="resource-detail__related-link">
                                    <span>View Resource</span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ─── COMMUNITY CTA ─── --}}
    <section class="resource-detail__community">
        <div class="resource-detail__community-bg">
            <div class="resource-detail__community-shape resource-detail__community-shape--1"></div>
            <div class="resource-detail__community-shape resource-detail__community-shape--2"></div>
        </div>

        <div class="wrap">
            <div class="resource-detail__community-content">
                <div class="resource-detail__community-icon">
                    <i class="fab fa-whatsapp"></i>
                </div>

                <h2 class="resource-detail__community-title">
                    Get new resources <span>as they drop</span>
                </h2>

                <p class="resource-detail__community-desc">
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

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/v150/resources.css') }}">
@endpush

@endsection