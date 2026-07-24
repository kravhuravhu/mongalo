@forelse($books as $book)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
            <div class="books-index__title">
                <span class="books-index__title-color" style="background:{{ $book->cover_color ?? '#a67c4e' }};"></span>
                <div>
                    <strong>{{ $book->title }}</strong>
                    @if($book->subtitle)
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">{{ $book->subtitle }}</span>
                    @endif
                </div>
            </div>
        </td>
        <td>
            @if($book->is_free)
                <span class="badge badge-free">Free</span>
            @else
                {{-- Use raw price casting to avoid formatting issues --}}
                <span class="books-index__price">{{ $book->price }}</span>
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
        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 40px;">
            <i class="fas fa-book" style="font-size: 2rem; display: block; margin-bottom: 12px; opacity: 0.3;"></i>
            No books found.
        </td>
    </tr>
@endforelse