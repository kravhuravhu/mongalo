<button type="button" class="library__book-open"
    data-book-id="{{ $book->id }}"
    data-title="{{ $book->title }}"
    data-subtitle="{{ $book->subtitle }}"
    data-desc="{{ $book->description }}"
    data-price="{{ (float) $book->raw_price }}"
    data-price-label="{{ $book->formatted_price }}"
    data-hardcopy="{{ $book->has_hardcopy_option ? '1' : '0' }}"
    data-hardcopy-price="{{ (float) $book->hardcopy_price_raw }}"
    data-hardcopy-label="{{ $book->formatted_hardcopy_price }}"
    data-color="{{ $book->cover_color ?? '#a67c4e' }}"
    data-cover="{{ $book->cover_image ? secure_asset('storage/books/covers/' . $book->cover_image) : '' }}">
    View book <span class="library__arrow">↗</span>
</button>