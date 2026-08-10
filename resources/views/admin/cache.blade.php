@extends('admin.layouts.admin')

@section('title', 'Cache Management · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Cache Management')
@section('breadcrumb', 'System / Cache')

@section('content')

<div class="cache-manager">
    <div class="cache-manager__header">
        <h2 style="font-family: var(--font-serif); font-weight: 700; margin-bottom: 20px;">
            <i class="fas fa-database" style="color: var(--gold);"></i> Cache Management
        </h2>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        {{-- Cache Stats --}}
        <div class="stat-card" style="background: var(--bg);">
            <div class="stat-number">{{ Cache::get('cache_hits', 0) }}</div>
            <div class="stat-label"><i class="fas fa-check-circle" style="color: #28a745;"></i> Cache Hits</div>
        </div>
        <div class="stat-card" style="background: var(--bg);">
            <div class="stat-number">{{ Cache::get('cache_misses', 0) }}</div>
            <div class="stat-label"><i class="fas fa-times-circle" style="color: #dc3545;"></i> Cache Misses</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-bottom: 24px;">
        <a href="{{ route('admin.cache.clear') }}" class="btn btn--danger btn--lg" onclick="return confirm('Are you sure you want to clear all cache?');">
            <i class="fas fa-trash"></i> Clear All Cache
        </a>
        <a href="{{ route('admin.cache.warm') }}" class="btn btn--primary btn--lg">
            <i class="fas fa-fire"></i> Warm Cache
        </a>
        <a href="{{ route('admin.cache.status') }}" class="btn btn--secondary btn--lg">
            <i class="fas fa-info-circle"></i> Cache Status
        </a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Cache Key</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>page_*</code></td>
                    <td>Page Cache</td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <a href="{{ route('admin.cache.clear', ['type' => 'page']) }}" class="btn btn--danger btn--sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><code>query_*</code></td>
                    <td>Query Cache</td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <a href="{{ route('admin.cache.clear', ['type' => 'query']) }}" class="btn btn--danger btn--sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td><code>stats_*</code></td>
                    <td>Stats Cache</td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <a href="{{ route('admin.cache.clear', ['type' => 'stats']) }}" class="btn btn--danger btn--sm">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection