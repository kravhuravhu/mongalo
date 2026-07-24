<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // ─── SEARCH ───
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('subtitle', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // ─── FILTER ───
        if ($request->filter === 'paid') {
            $query->where('is_free', false);
        } elseif ($request->filter === 'free') {
            $query->where('is_free', true);
        } elseif ($request->filter === 'featured') {
            $query->where('is_featured', true);
        }

        // ─── SORT BY LATEST ───
        $query->orderBy('created_at', 'desc');

        $books = $query->paginate(20);

        // ─── AJAX REQUEST ───
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
        ]);

        Book::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'is_free' => $request->is_free ?? false,
            'is_featured' => $request->is_featured ?? false,
            'cover_color' => $request->cover_color ?? '#a67c4e',
            'sort_order' => Book::count() + 1,
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
            'sort_order' => 'nullable|integer|min:1',
        ]);

        $book->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'price' => $request->price,
            'is_free' => $request->is_free ?? false,
            'is_featured' => $request->is_featured ?? false,
            'cover_color' => $request->cover_color ?? '#a67c4e',
            'sort_order' => $request->sort_order ?? $book->sort_order,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }
}