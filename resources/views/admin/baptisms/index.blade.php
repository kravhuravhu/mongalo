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
                    <th style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody id="baptismsSearchResults">
                @forelse($baptisms as $baptism)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $baptism->name }}</strong>
                        </td>
                        <td>
                            <div class="baptisms-index__contact">
                                <a href="mailto:{{ $baptism->email }}" style="color: var(--gold); text-decoration: none; font-size: 0.85rem;">
                                    {{ $baptism->email }}
                                </a>
                                <a href="tel:{{ $baptism->phone }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.8rem; display: block;">
                                    {{ $baptism->phone }}
                                </a>
                            </div>
                        </td>
                        <td>
                            <span class="baptisms-index__location">
                                <i class="fas fa-map-marker-alt" style="color: var(--gold); font-size: 0.7rem;"></i>
                                {{ $baptism->location }}
                            </span>
                        </td>
                        <td>
                            @if($baptism->preferred_date)
                                <span style="font-size: 0.85rem;">
                                    {{ $baptism->preferred_date->format('M d, Y') }}
                                </span>
                            @else
                                <span style="color: var(--text-muted); font-size: 0.8rem;">Not specified</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $baptism->status }}">
                                {{ ucfirst($baptism->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="baptisms-index__actions">
                                <form method="POST" action="{{ route('admin.baptisms.update', $baptism) }}" class="status-update-form">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="baptisms-index__status-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $baptism->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="contacted" {{ $baptism->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                        <option value="completed" {{ $baptism->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                                <a href="mailto:{{ $baptism->email }}" class="btn btn--secondary btn--sm" title="Email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <a href="tel:{{ $baptism->phone }}" class="btn btn--secondary btn--sm" title="Call">
                                    <i class="fas fa-phone"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-water" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No baptism requests found.
                        </td>
                    </tr>
                @endforelse
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
    <link rel="stylesheet" href="{{ secure_asset('css/admin/baptisms.css') }}">
@endpush