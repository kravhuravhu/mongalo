@extends('admin.layouts.admin')

@section('title', 'Books · ' . env('PROJECT_NAME', 'The Collective'))
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
        
        {{-- Clear Filters Button --}}
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
                    <th>Price</th>
                    <th>File</th>
                    <th>Status</th>
                    <th style="width: 80px;">Sort</th>
                    <th style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody id="adminSearchResults">
                @forelse($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="books-index__title">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/books/covers/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px; border: 1px solid var(--border); flex-shrink: 0;">
                                @else
                                    <span class="books-index__title-color" style="background:{{ $book->cover_color ?? '#a67c4e' }};"></span>
                                @endif
                                <div>
                                    <strong>{{ $book->title }}</strong>
                                    @if($book->subtitle)
                                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">{{ $book->subtitle }}</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($book->cover_image)
                                <span class="badge badge-free" style="background: #d4edda; color: #155724;">
                                    <i class="fas fa-check-circle"></i> Uploaded
                                </span>
                            @else
                                <span class="badge badge-read" style="background: #f8d7da; color: #721c24;">
                                    <i class="fas fa-times-circle"></i> None
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($book->is_free)
                                <span class="badge badge-free">Free</span>
                            @else
                                <span class="books-index__price">R{{ number_format((float) $book->price, 2) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($book->book_file)
                                <span class="badge badge-free" style="background: #d4edda; color: #155724;">
                                    <i class="fas fa-check-circle"></i> {{ strtoupper($book->file_type) }}
                                </span>
                            @else
                                <span class="badge badge-read" style="background: #f8d7da; color: #721c24;">
                                    <i class="fas fa-times-circle"></i> None
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($book->is_featured)
                                <span class="badge badge-featured">★ Featured</span>
                            @else
                                <span class="badge badge-read">Standard</span>
                            @endif
                        </td>
                        <td>
                            <span class="sort-order-display">{{ $book->sort_order }}</span>
                        </td>
                        <td>
                            <div class="books-index__actions">
                                <a href="{{ route('admin.books.edit', $book) }}" class="btn btn--secondary btn--sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.books.destroy', $book) }}" class="delete-confirm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn--danger btn--sm" title="Delete" 
                                            data-title="{{ $book->title }}" 
                                            data-type="Book">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 40px;">
                            <i class="fas fa-book" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
                            No books found.
                            @if(request('search') || request('filter'))
                                <br>
                                <a href="{{ route('admin.books.index') }}" class="btn btn--primary btn--sm" style="margin-top: 12px;">Clear filters</a>
                            @else
                                <br>
                                <a href="{{ route('admin.books.create') }}" class="btn btn--primary btn--sm" style="margin-top: 12px;">Add your first book</a>
                            @endif
                        </td>
                    </tr>
                @endforelse
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
    <link rel="stylesheet" href="{{ secure_asset('css/admin/books.css') }}">
@endpush