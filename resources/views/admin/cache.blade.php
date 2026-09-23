@extends('admin.layouts.admin')

@section('title', 'Cache Management · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Cache Management')
@section('breadcrumb', 'System / Cache')

@section('content')

<div class="cache-manager">
    {{-- ─── HEADER ─── --}}
    <div class="cache-manager__header">
        <h2><i class="fas fa-database"></i> Cache Management</h2>
        <p>Monitor cache performance and clear stored data when needed.</p>
    </div>

    {{-- ─── STATS ─── --}}
    <div class="cache-manager__stats">
        <div class="cache-manager__stat cache-manager__stat--hits">
            <span class="cache-manager__stat-number">{{ Cache::get('cache_hits', 0) }}</span>
            <span class="cache-manager__stat-label">
                <i class="fas fa-check-circle"></i> Cache Hits
            </span>
        </div>
        <div class="cache-manager__stat cache-manager__stat--misses">
            <span class="cache-manager__stat-number">{{ Cache::get('cache_misses', 0) }}</span>
            <span class="cache-manager__stat-label">
                <i class="fas fa-times-circle"></i> Cache Misses
            </span>
        </div>
    </div>

    {{-- ─── ACTIONS ─── --}}
    <div class="cache-manager__actions">
        <a href="{{ route('admin.cache.clear') }}" class="btn btn--danger btn--lg" onclick="return confirm('Are you sure you want to clear all cache? This will affect page, query, and stats cache.');">
            <i class="fas fa-trash"></i> Clear All Cache
        </a>
        <a href="{{ route('admin.cache.warm') }}" class="btn btn--primary btn--lg">
            <i class="fas fa-fire"></i> Warm Cache
        </a>
        <a href="{{ route('admin.cache.status') }}" class="btn btn--secondary btn--lg">
            <i class="fas fa-info-circle"></i> Cache Status
        </a>
    </div>

    {{-- ─── CACHE TYPES TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Cache Key</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th style="width: 80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="cache-key">page_*</span></td>
                    <td><span class="cache-type">Page Cache</span></td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <div class="cache-action-cell">
                            <a href="{{ route('admin.cache.clear', ['type' => 'page']) }}" class="btn btn--danger btn--sm" title="Clear Page Cache" onclick="return confirm('Clear page cache?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="cache-key">query_*</span></td>
                    <td><span class="cache-type">Query Cache</span></td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <div class="cache-action-cell">
                            <a href="{{ route('admin.cache.clear', ['type' => 'query']) }}" class="btn btn--danger btn--sm" title="Clear Query Cache" onclick="return confirm('Clear query cache?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><span class="cache-key">stats_*</span></td>
                    <td><span class="cache-type">Stats Cache</span></td>
                    <td><span class="badge badge-free">Active</span></td>
                    <td>
                        <div class="cache-action-cell">
                            <a href="{{ route('admin.cache.clear', ['type' => 'stats']) }}" class="btn btn--danger btn--sm" title="Clear Stats Cache" onclick="return confirm('Clear stats cache?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/cache.css') }}">
@endpush