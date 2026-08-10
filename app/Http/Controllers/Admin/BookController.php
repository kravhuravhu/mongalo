<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        /* ─── SEARCH ─── */
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('subtitle', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        /* ─── FILTER ─── */
        if ($request->filter === 'paid') {
            $query->where('is_free', false);
        } elseif ($request->filter === 'free') {
            $query->where('is_free', true);
        } elseif ($request->filter === 'featured') {
            $query->where('is_featured', true);
        }

        /* ─── SORT BY LATEST ─── */
        $query->orderBy('created_at', 'desc');

        $books = $query->paginate(20);

        /* ─── AJAX REQUEST ─── */
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.books._table', compact('books'))->render(),
                'total' => $books->total(),
            ]);
        }

        // ─── NORMAL REQUEST ───
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_featured' => 'boolean',
            'cover_color' => 'nullable|max:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'book_file' => 'required_if:is_free,false|nullable|file|mimes:pdf,epub,mobi,docx|max:51200',
            'file_type' => 'nullable|in:pdf,epub,mobi,docx',
        ], [
            'book_file.required_if' => 'The book file is required for paid books.',
            'book_file.max' => 'The book file must not be greater than 50MB.',
            'book_file.mimes' => 'The book file must be a PDF, EPUB, MOBI, or DOCX file.',
            'cover_image.max' => 'The cover image must not be greater than 2MB.',
            'cover_image.mimes' => 'The cover image must be a JPEG, PNG, or WEBP file.',
        ]);

        $bookData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'is_free' => $request->is_free ?? false,
            'is_featured' => $request->is_featured ?? false,
            'cover_color' => $request->cover_color ?? '#a67c4e',
            'sort_order' => Book::count() + 1,
        ];

        /* ─── UPLOAD COVER IMAGE ─── */
        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverName = 'cover-' . time() . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->storeAs('books/covers', $coverName, 'public');
            $bookData['cover_image'] = $coverName;
        }

        /* ─── UPLOAD BOOK FILE ─── */
        if ($request->hasFile('book_file')) {
            $bookFile = $request->file('book_file');
            $fileName = Str::slug($request->title) . '-' . time() . '.' . $bookFile->getClientOriginalExtension();
            $bookFile->storeAs('books/files', $fileName, 'public');
            
            $bookData['book_file'] = $fileName;
            $bookData['file_type'] = $request->file_type ?? $bookFile->getClientOriginalExtension();
            $bookData['file_size'] = $this->formatFileSize($bookFile->getSize());
        }

        $book = Book::create($bookData);

        Log::info('Book created by admin', [
            'book_id' => $book->id,
            'book_title' => $book->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|max:255',
            'subtitle' => 'nullable|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric|min:0',
            'is_free' => 'boolean',
            'is_featured' => 'boolean',
            'cover_color' => 'nullable|max:50',
            'cover_image' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'book_file' => 'nullable|file|mimes:pdf,epub,mobi,docx|max:51200',
            'file_type' => 'nullable|in:pdf,epub,mobi,docx',
            'sort_order' => 'nullable|integer|min:1',
        ]);

        $bookData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'is_free' => $request->is_free ?? false,
            'is_featured' => $request->is_featured ?? false,
            'cover_color' => $request->cover_color ?? '#a67c4e',
            'sort_order' => $request->sort_order ?? $book->sort_order,
        ];

        /* ─── UPLOAD COVER IMAGE ─── */
        if ($request->hasFile('cover_image')) {
            /* ─── DELETE OLD COVER ─── */
            if ($book->cover_image) {
                Storage::disk('public')->delete('books/covers/' . $book->cover_image);
            }
            
            $coverFile = $request->file('cover_image');
            $coverName = 'cover-' . time() . '.' . $coverFile->getClientOriginalExtension();
            $coverFile->storeAs('books/covers', $coverName, 'public');
            $bookData['cover_image'] = $coverName;
        }

        /* ─── UPLOAD BOOK FILE ─── */
        if ($request->hasFile('book_file')) {
            /* ─── DELETE OLD FILE ─── */
            if ($book->book_file) {
                Storage::disk('public')->delete('books/files/' . $book->book_file);
            }
            
            $bookFile = $request->file('book_file');
            $fileName = Str::slug($request->title) . '-' . time() . '.' . $bookFile->getClientOriginalExtension();
            $bookFile->storeAs('books/files', $fileName, 'public');
            
            $bookData['book_file'] = $fileName;
            $bookData['file_type'] = $request->file_type ?? $bookFile->getClientOriginalExtension();
            $bookData['file_size'] = $this->formatFileSize($bookFile->getSize());
        }

        $book->update($bookData);

        Log::info('Book updated by admin', [
            'book_id' => $book->id,
            'book_title' => $book->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book, Request $request)
    {
        Log::info('Book deleted by admin', [
            'book_id' => $book->id,
            'book_title' => $book->title,
            'admin_id' => session('admin_id'),
            'admin_name' => session('admin_name'),
            'ip' => $request->ip(),
        ]);

        /* ─── DELETE FILES ─── */
        if ($book->cover_image) {
            Storage::disk('public')->delete('books/covers/' . $book->cover_image);
        }
        if ($book->book_file) {
            Storage::disk('public')->delete('books/files/' . $book->book_file);
        }

        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }

    /* ─── HELPER: Format File Size ─── */
    private function formatFileSize($bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}