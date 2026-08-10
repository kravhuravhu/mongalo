<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Services\CacheService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        // ─── GET CACHED DATA ───
        $cacheKey = $this->cacheService->key('books', ['list' => 'all']);
        
        $data = $this->cacheService->rememberClosure($cacheKey, function () {
            return [
                'paidBooks' => Book::where('is_free', false)->orderBy('sort_order')->get(),
                'freeBooks' => Book::where('is_free', true)->orderBy('sort_order')->get(),
            ];
        });

        return view('public.books.index', $data);
    }

    public function show($slug)
    {
        // ─── GET BOOK DIRECTLY (NO CACHE TO AVOID INCOMPLETE OBJECT ISSUE) ───
        $book = Book::where('slug', $slug)->firstOrFail();

        // ─── GET RELATED BOOKS DIRECTLY ───
        $relatedBooks = Book::where('id', '!=', $book->id)
            ->where('is_free', $book->is_free)
            ->limit(3)
            ->get();

        return view('public.books.show', compact('book', 'relatedBooks'));
    }

    /* ─── DOWNLOAD FREE BOOK ─── */
    public function download(Book $book)
    {
        if (!$book->is_free || !$book->book_file) {
            abort(404, 'Book not available for free download.');
        }

        $filePath = storage_path('app/public/books/files/' . $book->book_file);

        if (!file_exists($filePath)) {
            abort(404, 'Book file not found.');
        }

        // ─── INCREMENT DOWNLOAD COUNT ───
        $book->increment('download_count');

        $fileName = $book->slug . '.' . $book->file_type;

        return response()->download($filePath, $fileName, [
            'Content-Type' => $this->getMimeType($book->file_type),
        ]);
    }

    /* ─── GET MIME TYPE ─── */
    protected function getMimeType(string $fileType): string
    {
        return match ($fileType) {
            'pdf' => 'application/pdf',
            'epub' => 'application/epub+zip',
            'mobi' => 'application/x-mobipocket-ebook',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            default => 'application/octet-stream',
        };
    }
}