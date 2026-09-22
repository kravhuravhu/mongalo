@extends('admin.layouts.admin')

@section('title', 'Events · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Events')
@section('breadcrumb', 'Manage Events')

@section('content')

<div class="events-index">
    {{-- ─── HEADER ACTIONS ─── --}}
    <div class="events-index__header">
        <div class="events-index__search">
            <div class="events-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text"
                    id="eventsSearchInput"
                    placeholder="Search events..."
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="eventsSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="eventsSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
            <span class="events-index__search-hint">
                <i class="fas fa-keyboard"></i> Type to search · <kbd>Ctrl</kbd>+<kbd>/</kbd> to focus · <kbd>Esc</kbd> to clear
            </span>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn--primary">
            <i class="fas fa-plus"></i> Add Event
        </a>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="events-index__filters">
        <a href="{{ route('admin.events.index') }}"
           class="events-index__filter {{ !request('filter') ? 'events-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.events.index', ['filter' => 'upcoming']) }}"
           class="events-index__filter {{ request('filter') === 'upcoming' ? 'events-index__filter--active' : '' }}">
            Upcoming
        </a>
        <a href="{{ route('admin.events.index', ['filter' => 'past']) }}"
           class="events-index__filter {{ request('filter') === 'past' ? 'events-index__filter--active' : '' }}">
            Past
        </a>

        @if(request('filter') || request('search'))
            <a href="{{ route('admin.events.index') }}" class="events-index__filter events-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif

        <span class="events-index__filter-count">
            {{ $events->total() }} events
            <span style="font-size: 0.65rem; color: var(--muted); margin-left: 8px;">
                ({{ $upcomingCount ?? 0 }} upcoming · {{ $pastCount ?? 0 }} past)
            </span>
        </span>
    </div>

    {{-- ─── EVENTS TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Title</th>
                    <th>Date & Time</th>
                    <th>Location</th>
                    <th>Registrations</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody id="eventsSearchResults">
                @include('admin.events._table')
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($events->hasPages())
        <div class="pagination-container">
            {{ $events->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/events.css') }}">
@endpush