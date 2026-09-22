@extends('admin.layouts.admin')

@section('title', 'Cache Status · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Cache Status')
@section('breadcrumb', 'System / Cache / Status')

@section('content')

<div class="cache-status">
    {{-- ─── HEADER ─── --}}
    <div class="cache-status__header">
        <a href="{{ route('admin.cache.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Cache
        </a>
    </div>

    {{-- ─── STATUS CARD ─── --}}
    <div class="cache-status__card">
        <h3><i class="fas fa-info-circle"></i> Cache Status</h3>

        <div class="cache-status__grid">
            {{-- ─── CACHE DRIVER ─── --}}
            <div class="cache-status__item">
                <span class="cache-status__label">Cache Driver</span>
                <span class="cache-status__value">{{ $status['driver'] }}</span>
            </div>

            {{-- ─── CACHE ENABLED ─── --}}
            <div class="cache-status__item">
                <span class="cache-status__label">Cache Enabled</span>
                <span class="cache-status__value {{ $status['enabled'] ? 'cache-status__value--yes' : 'cache-status__value--no' }}">
                    @if($status['enabled'])
                        <i class="fas fa-check-circle"></i> Yes
                    @else
                        <i class="fas fa-times-circle"></i> No
                    @endif
                </span>
            </div>

            {{-- ─── PAGE CACHE ─── --}}
            <div class="cache-status__item">
                <span class="cache-status__label">Page Cache</span>
                <span class="cache-status__value {{ $status['page_cache'] ? 'cache-status__value--yes' : 'cache-status__value--no' }}">
                    @if($status['page_cache'])
                        <i class="fas fa-check-circle"></i> Enabled
                    @else
                        <i class="fas fa-times-circle"></i> Disabled
                    @endif
                </span>
                @if($status['page_cache'])
                    <span class="cache-status__sub">TTL: {{ $status['page_cache_ttl'] }}s</span>
                @endif
            </div>

            {{-- ─── QUERY CACHE ─── --}}
            <div class="cache-status__item">
                <span class="cache-status__label">Query Cache</span>
                <span class="cache-status__value {{ $status['query_cache'] ? 'cache-status__value--yes' : 'cache-status__value--no' }}">
                    @if($status['query_cache'])
                        <i class="fas fa-check-circle"></i> Enabled
                    @else
                        <i class="fas fa-times-circle"></i> Disabled
                    @endif
                </span>
                @if($status['query_cache'])
                    <span class="cache-status__sub">TTL: {{ $status['query_cache_ttl'] }}s</span>
                @endif
            </div>

            {{-- ─── CACHE SIZE ─── --}}
            <div class="cache-status__item cache-status__item--wide">
                <span class="cache-status__label">Cache Size</span>
                <span class="cache-status__value">{{ $status['cache_size'] }}</span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/cache.css') }}">
@endpush