@if($book->cover_image)
    <img src="{{ secure_asset('storage/books/covers/' . $book->cover_image) }}" alt="{{ $book->title }} book cover" class="library__book3d-img">
@else
    <div class="library__book3d-fallback" style="background: {{ $book->cover_color ?? '#a67c4e' }};"><span>{{ $book->title }}</span></div>
@endif