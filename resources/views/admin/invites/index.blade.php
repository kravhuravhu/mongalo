@extends('admin.layouts.admin')

@section('title', 'Invite Requests · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Invite Requests')
@section('breadcrumb', 'Invites')

@section('content')

<div class="invites-index">
    {{-- ─── HEADER ─── --}}
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
                    <th style="width: 200px;">Actions</th>
                </tr>
            </thead>
            <tbody id="invitesSearchResults">
                @include('admin.invites._table')
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
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/invites.css') }}">
@endpush