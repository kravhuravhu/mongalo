@extends('admin.layouts.admin')

@section('title', 'Contact Messages · ' . env('PROJECT_NAME', 'The Collective'))
@section('page-title', 'Contact Messages')
@section('breadcrumb', 'Messages')

@section('content')

<div class="messages-index">
    {{-- ─── HEADER ─── --}}
    <div class="messages-index__header">
        <div class="messages-index__search">
            <div class="messages-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text"
                    id="messagesSearchInput"
                    placeholder="Search by name, email or subject..."
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="messagesSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="messagesSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
        </div>
        <span class="messages-index__count">{{ $messages->total() }} total messages</span>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="messages-index__filters">
        <a href="{{ route('admin.messages') }}"
           class="messages-index__filter {{ !request('status') ? 'messages-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.messages', ['status' => 'unread']) }}"
           class="messages-index__filter {{ request('status') === 'unread' ? 'messages-index__filter--active' : '' }}">
            Unread
            @php $unread = App\Models\ContactMessage::where('status', 'unread')->count(); @endphp
            @if($unread > 0)
                <span class="messages-index__badge messages-index__badge--danger">{{ $unread }}</span>
            @endif
        </a>
        <a href="{{ route('admin.messages', ['status' => 'read']) }}"
           class="messages-index__filter {{ request('status') === 'read' ? 'messages-index__filter--active' : '' }}">
            Read
        </a>
        <a href="{{ route('admin.messages', ['status' => 'replied']) }}"
           class="messages-index__filter {{ request('status') === 'replied' ? 'messages-index__filter--active' : '' }}">
            Replied
        </a>

        @if(request('status') || request('search'))
            <a href="{{ route('admin.messages') }}" class="messages-index__filter messages-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
    </div>

    {{-- ─── MESSAGES TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>From</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Received</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody id="messagesSearchResults">
                @include('admin.messages._table')
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($messages->hasPages())
        <div class="pagination-container">
            {{ $messages->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/messages.css') }}">
@endpush