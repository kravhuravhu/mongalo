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
        
        <span class="events-index__filter-count">{{ $events->total() }} events</span>
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
                @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="events-index__title">
                                <strong>{{ $event->title }}</strong>
                                @if($event->description)
                                    <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">
                                        {{ Str::limit($event->description, 60) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="events-index__date">
                                <span class="events-index__date-day">{{ $event->date->format('M d, Y') }}</span>
                                <span class="events-index__date-time">{{ \Carbon\Carbon::parse($event->time)->format('g:i A') }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="events-index__location">
                                <i class="fas fa-map-marker-alt" style="color: var(--gold); font-size: 0.7rem;"></i>
                                {{ $event->location }}
                            </span>
                        </td>
                        <td>
                            <span class="events-index__registrations">
                                {{ $event->registrations()->count() }}
                                @if($event->capacity)
                                    / {{ $event->capacity }}
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($event->is_free)
                                <span class="badge badge-free">Free</span>
                            @else
                                <span class="events-index__price">R{{ number_format($event->price ?? 0, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($event->is_past)
                                <span class="badge badge-completed">Past</span>
                            @else
                                <span class="badge badge-contacted">Upcoming</span>
                            @endif
                        </td>
                        <td>
                            <div class="events-index__actions">
                                <a href="{{ route('admin.events.registrations', $event) }}" class="btn btn--secondary btn--sm" title="View Registrations">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn--secondary btn--sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="delete-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm" title="Delete" 
                                            data-title="{{ $event->title }}" 
                                            data-type="Event">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-calendar-alt" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No events found.
                            @if(request('search') || request('filter'))
                                <br>
                                <a href="{{ route('admin.events.index') }}" class="btn btn--primary btn--sm" style="margin-top: 12px;">Clear filters</a>
                            @else
                                <br>
                                <a href="{{ route('admin.events.create') }}" class="btn btn--primary btn--sm" style="margin-top: 12px;">Add your first event</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
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
    <link rel="stylesheet" href="{{ secure_asset('css/admin/events.css') }}">
@endpush