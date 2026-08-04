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
        </td>
    </tr>
@endforelse