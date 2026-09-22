@extends('admin.layouts.admin')

@section('title', 'Baptism Requests · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Baptism Requests')
@section('breadcrumb', 'Baptisms')

@section('content')

<div class="baptisms-index">
    {{-- ─── HEADER ACTIONS ─── --}}
    <div class="baptisms-index__header">
        <div class="baptisms-index__search">
            <div class="baptisms-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text"
                    id="baptismsSearchInput"
                    placeholder="Search by name, email or location..."
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="baptismsSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="baptismsSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
        <span class="baptisms-index__count">{{ $baptisms->total() }} total requests</span>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="baptisms-index__filters">
        <a href="{{ route('admin.baptisms') }}"
           class="baptisms-index__filter {{ !request('status') ? 'baptisms-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.baptisms', ['status' => 'pending']) }}"
           class="baptisms-index__filter {{ request('status') === 'pending' ? 'baptisms-index__filter--active' : '' }}">
            Pending
            @php $pending = App\Models\BaptismRequest::where('status', 'pending')->count(); @endphp
            @if($pending > 0)
                <span class="baptisms-index__badge">{{ $pending }}</span>
            @endif
        </a>
        <a href="{{ route('admin.baptisms', ['status' => 'contacted']) }}"
           class="baptisms-index__filter {{ request('status') === 'contacted' ? 'baptisms-index__filter--active' : '' }}">
            Contacted
        </a>
        <a href="{{ route('admin.baptisms', ['status' => 'completed']) }}"
           class="baptisms-index__filter {{ request('status') === 'completed' ? 'baptisms-index__filter--active' : '' }}">
            Completed
        </a>

        @if(request('status') || request('search'))
            <a href="{{ route('admin.baptisms') }}" class="baptisms-index__filter baptisms-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
    </div>

    {{-- ─── BAPTISMS TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Location</th>
                    <th>Preferred Date</th>
                    <th>Status</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody id="baptismsSearchResults">
                @include('admin.baptisms._table')
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($baptisms->hasPages())
        <div class="pagination-container">
            {{ $baptisms->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/baptisms.css') }}">
@endpush