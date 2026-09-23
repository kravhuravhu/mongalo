@extends('admin.layouts.admin')

@section('title', 'Books · ' . env('PROJECT_NAME', 'IN.iN'))
@section('page-title', 'Books')
@section('breadcrumb', 'Manage Books')

@section('content')

<div class="books-index">
    {{-- ─── HEADER ACTIONS ─── --}}
    <div class="books-index__header">
        <div class="books-index__search">
            <div class="books-index__search-form">
                <i class="fas fa-search"></i>
                <input type="text" 
                    id="adminSearchInput" 
                    placeholder="Search books..." 
                    value="{{ request('search') }}"
                    autocomplete="off">
                <span class="admin-search-spinner" id="adminSearchSpinner"></span>
                <button class="btn btn--secondary btn--sm" id="adminSearchClear" style="display: {{ request('search') ? 'inline-flex' : 'none' }};">
                    <i class="fas fa-times"></i> Clear
                </button>
            </div>
            <span class="books-index__search-hint">
                <i class="fas fa-keyboard"></i> Type to search · <kbd>Ctrl</kbd>+<kbd>/</kbd> to focus · <kbd>Esc</kbd> to clear
            </span>
        </div>
        <a href="{{ route('admin.books.create') }}" class="btn btn--primary">
            <i class="fas fa-plus"></i> Add Book
        </a>
    </div>

    {{-- ─── FILTERS ─── --}}
    <div class="books-index__filters">
        <a href="{{ route('admin.books.index') }}" 
           class="books-index__filter {{ !request('filter') ? 'books-index__filter--active' : '' }}">
            All
        </a>
        <a href="{{ route('admin.books.index', ['filter' => 'paid']) }}" 
           class="books-index__filter {{ request('filter') === 'paid' ? 'books-index__filter--active' : '' }}">
            Paid
        </a>
        <a href="{{ route('admin.books.index', ['filter' => 'free']) }}" 
           class="books-index__filter {{ request('filter') === 'free' ? 'books-index__filter--active' : '' }}">
            Free
        </a>
        <a href="{{ route('admin.books.index', ['filter' => 'featured']) }}" 
           class="books-index__filter {{ request('filter') === 'featured' ? 'books-index__filter--active' : '' }}">
            Featured
        </a>
        
        @if(request('filter') || request('search'))
            <a href="{{ route('admin.books.index') }}" class="books-index__filter books-index__filter--clear">
                <i class="fas fa-times"></i> Clear Filters
            </a>
        @endif
        
        <span class="books-index__filter-count">{{ $books->total() }} books</span>
    </div>

    {{-- ─── BOOKS TABLE ─── --}}
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width: 40px;">#</th>
                    <th>Title</th>
                    <th>Cover</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>File</th>
                    <th>Status</th>
                    <th style="width: 80px;">Sort</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody id="adminSearchResults">
                @include('admin.books._table', ['books' => $books])
            </tbody>
        </table>
    </div>

    {{-- ─── PAGINATION ─── --}}
    @if($books->hasPages())
        <div class="pagination-container">
            {{ $books->links() }}
        </div>
    @endif
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ secure_asset('css/admin/v150/books.css') }}">
@endpush