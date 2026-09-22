@forelse($books as $book)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="books-index__title">
                @if($book->cover_image)
                    <img src="{{ asset('storage/books/covers/' . $book->cover_image) }}" alt="{{ $book->title }}">
                @else
                    <span class="books-index__title-color" style="background:{{ $book->cover_color ?? '#B8926A' }};"></span>
                @endif
                <div>
                    <strong>{{ $book->title }}</strong>
                    @if($book->subtitle)
                        <span>{{ $book->subtitle }}</span>
                    @endif
                </div>
            </div>
        </td>
        <td>
            @if($book->cover_image)
                <span class="badge badge-free">
                    <i class="fas fa-check-circle"></i> Uploaded
                </span>
            @else
                <span class="badge badge-failed">
                    <i class="fas fa-times-circle"></i> None
                </span>
            @endif
        </td>
        <td>
            @if($book->is_free && $book->category)
                <span class="badge badge-featured">
                    {{ $book->category_label }}
                </span>
            @else
                <span style="font-family: var(--font-sans); font-size: 0.7rem; color: var(--muted);">—</span>
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
                <span class="badge badge-free">
                    <i class="fas fa-check-circle"></i> {{ strtoupper($book->file_type) }}
                </span>
            @else
                <span class="badge badge-failed">
                    <i class="fas fa-times-circle"></i> None
                </span>
            @endif
        </td>
        <td>
            @if($book->is_featured)
                <span class="badge badge-featured">
                    <i class="fas fa-star"></i> Featured
                </span>
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
        <td colspan="9" style="text-align: center; color: var(--muted); padding: 48px 20px;">
            <i class="fas fa-book" style="font-size: 2.4rem; display: block; margin-bottom: 16px; opacity: 0.25;"></i>
            <span style="font-family: var(--font-italic); font-style: italic; font-size: 0.95rem;">No books found.</span>
            @if(request('search') || request('filter'))
                <br>
                <a href="{{ route('admin.books.index') }}" class="btn btn--primary btn--sm" style="margin-top: 16px;">Clear filters</a>
            @else
                <br>
                <a href="{{ route('admin.books.create') }}" class="btn btn--primary btn--sm" style="margin-top: 16px;">Add your first book</a>
            @endif
        </td>
    </tr>
@endforelse