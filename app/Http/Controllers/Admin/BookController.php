<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::orderBy('sort_order')->get();
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
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully!');
    }
}