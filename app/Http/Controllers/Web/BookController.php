<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        // ─── OPEN IT IN THE LIBRARY MODAL ───
        $route = $book->is_free ? 'resources' : 'books.index';
        return redirect()->route($route, ['open' => $book->slug], 301);
    }

    /* ─── FREE BOOK DOWNLOAD WITH VALIDATION ─── */
    public function download(Book $book, Request $request)
    {
        if (!$book->is_free || !$book->book_file) {
            abort(404, 'Book not available for free download.');
        }

        // ─── VALIDATE DOWNLOAD TOKEN ───
        $token = $request->get('token');
        $sessionKey = 'free_download_' . $book->id;

        // Generate token if not exists
        if (!$token) {
            $newToken = Str::random(64);
            session([$sessionKey => $newToken]);
            return redirect()->route('books.download', ['book' => $book->id, 'token' => $newToken]);
        }

        // Validate token matches session
        if (session($sessionKey) !== $token) {
            abort(403, 'Invalid download token.');
        }

        // ─── LIMIT DOWNLOADS PER SESSION ───
        $downloadCountKey = 'free_download_count_' . $book->id;
        $downloadCount = session($downloadCountKey, 0);

        if ($downloadCount >= 3) {
            abort(429, 'Download limit reached. Please contact us for access.');
        }

        session([$downloadCountKey => $downloadCount + 1]);

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

    /* ─── PREVIEW BOOK ─── */
    public function preview($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();

        // Only allow preview if book has content
        if (!$book->book_file) {
            abort(404, 'Preview not available.');
        }

        $filePath = storage_path('app/public/books/files/' . $book->book_file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found.');
        }

        // For PDF - render inline
        $fileName = $book->slug . '.' . $book->file_type;

        return response()->file($filePath, [
            'Content-Type' => $this->getMimeType($book->file_type),
            'Content-Disposition' => 'inline; filename="' . $fileName . '"',
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