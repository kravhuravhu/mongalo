@extends('admin.layouts.admin')

@section('title', 'Invite Requests · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Invite Requests')
@section('breadcrumb', 'Invites')

@section('content')

<div class="invites-index">
    {{-- ─── HEADER ACTIONS ─── --}}
    <div class="invites-index__header">
        <div class="invites-index__search">
            <div class="invites-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text" 
                    id="invitesSearchInput" 
                    placeholder="Search by name, email or event..." 
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="invitesSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="invitesSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
        <span class="invites-index__count">{{ $invites->total() }} total requests</span>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="invites-index__filters">
        <a href="{{ route('admin.invites') }}" 
           class="invites-index__filter {{ !request('status') ? 'invites-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.invites', ['status' => 'pending']) }}" 
           class="invites-index__filter {{ request('status') === 'pending' ? 'invites-index__filter--active' : '' }}">
            Pending
            @php $pending = App\Models\InviteRequest::where('status', 'pending')->count(); @endphp
            @if($pending > 0)
                <span class="invites-index__badge">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.invites', ['status' => 'contacted']) }}" 
           class="invites-index__filter {{ request('status') === 'contacted' ? 'invites-index__filter--active' : '' }}">
            Contacted
        </a>
        <a href="{{ route('admin.invites', ['status' => 'confirmed']) }}" 
           class="invites-index__filter {{ request('status') === 'confirmed' ? 'invites-index__filter--active' : '' }}">
            Confirmed
        </a>
        
        @if(request('status') || request('search'))
            <a href="{{ route('admin.invites') }}" class="invites-index__filter invites-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
    </div>

    {{-- ─── INVITES TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Requester</th>
                    <th>Event</th>
                    <th>Date & Location</th>
                    <th>Attendance</th>
                    <th>Status</th>
                    <th style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody id="invitesSearchResults">
                @forelse($invites as $invite)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="invites-index__requester">
                                <strong>{{ $invite->name }}</strong>
                                <a href="mailto:{{ $invite->email }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.8rem; display: block;">
                                    {{ $invite->email }}
                                </a>
                                <a href="tel:{{ $invite->phone }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.75rem;">
                                    <i class="fas fa-phone"></i> {{ $invite->phone }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <span class="invites-index__event">{{ $invite->event_name }}</span>
                            @if($invite->message)
                                <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">
                                    {{ Str::limit($invite->message, 40) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="invites-index__date">
                                <span style="font-size: 0.85rem;">{{ $invite->event_date->format('M d, Y') }}</span>
                                <span style="font-size: 0.75rem; color: var(--text-muted); display: block;">
                                    <i class="fas fa-map-marker-alt" style="color: var(--gold);"></i>
                                    {{ $invite->location }}
                                </span>
                            </div>
                        </td>
                        <td>
                            @if($invite->expected_attendance)
                                <span class="invites-index__attendance">
                                    <i class="fas fa-users" style="color: var(--gold);"></i>
                                    {{ $invite->expected_attendance }}
                                </span>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.8rem;">Not specified</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $invite->status }}">
                                {{ ucfirst($invite->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="invites-index__actions">
                                <form method="POST" action="{{ route('admin.invites.update', $invite) }}" class="status-update-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="invites-index__status-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $invite->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted" {{ $invite->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="confirmed" {{ $invite->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    </select>
                                </form>
                                <a href="mailto:{{ $invite->email }}" class="btn btn--secondary btn--sm" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="tel:{{ $invite->phone }}" class="btn btn--secondary btn--sm" title="Call">
                                    <i class="fas fa-phone"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-handshake" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No invite requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($invites->hasPages())
        <div class="pagination-container">
            {{ $invites->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/invites.css') }}">
@endpush