@extends('admin.layouts.admin')

@section('title', 'Cache Status · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Cache Status')
@section('breadcrumb', 'System / Cache / Status')

@section('content')

<div class="cache-status">
    <div class="cache-status__header">
        <a href="{{ route('admin.cache.index') }}" class="btn btn--secondary">
            <i class="fas fa-arrow-left"></i> Back to Cache
        </a>
    </div>

    <div class="cache-status__card" style="background: var(--surface); border-radius: var(--radius); border: 1px solid var(--border); padding: 32px; margin-top: 20px;">
        <h3 style="font-family: var(--font-serif); font-weight: 700; margin-bottom: 20px;">
            <i class="fas fa-info-circle" style="color: var(--gold);"></i> Cache Status
        </h3>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div style="background: var(--bg); padding: 16px 20px; border-radius: var(--radius-sm);">
                <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">Cache Driver</span>
                <span style="font-weight: 600; font-size: 1.1rem;">{{ $status['driver'] }}</span>
            </div>

            <div style="background: var(--bg); padding: 16px 20px; border-radius: var(--radius-sm);">
                <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">Cache Enabled</span>
                <span style="font-weight: 600; font-size: 1.1rem;">
                    @if($status['enabled'])
                        <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Yes</span>
                    @else
                        <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> No</span>
                    @endif
                </span>
            </div>

            <div style="background: var(--bg); padding: 16px 20px; border-radius: var(--radius-sm);">
                <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">Page Cache</span>
                <span style="font-weight: 600; font-size: 1.1rem;">
                    @if($status['page_cache'])
                        <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Enabled</span>
                        <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">TTL: {{ $status['page_cache_ttl'] }}s</span>
                    @else
                        <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> Disabled</span>
                    @endif
                </span>
            </div>

            <div style="background: var(--bg); padding: 16px 20px; border-radius: var(--radius-sm);">
                <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">Query Cache</span>
                <span style="font-weight: 600; font-size: 1.1rem;">
                    @if($status['query_cache'])
                        <span style="color: #28a745;"><i class="fas fa-check-circle"></i> Enabled</span>
                        <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">TTL: {{ $status['query_cache_ttl'] }}s</span>
                    @else
                        <span style="color: #dc3545;"><i class="fas fa-times-circle"></i> Disabled</span>
                    @endif
                </span>
            </div>

            <div style="background: var(--bg); padding: 16px 20px; border-radius: var(--radius-sm); grid-column: 1 / -1;">
                <span style="display: block; font-size: 0.7rem; color: var(--text-muted);">Cache Size</span>
                <span style="font-weight: 600; font-size: 1.1rem;">{{ $status['cache_size'] }}</span>
            </div>
        </div>
    </div>
</div>

@endsection