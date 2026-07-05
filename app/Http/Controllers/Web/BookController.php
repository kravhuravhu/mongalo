<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $paidBooks = Book::where('is_free', false)->orderBy('sort_order')->get();
        $freeBooks = Book::where('is_free', true)->orderBy('sort_order')->get();

        return view('public.books.index', compact('paidBooks', 'freeBooks'));
    }

    public function show($slug)
    {
        $book = Book::where('slug', $slug)->firstOrFail();
        $relatedBooks = Book::where('id', '!=', $book->id)
            ->where('is_free', $book->is_free)
            ->limit(3)
            ->get();

        return view('public.books.show', compact('book', 'relatedBooks'));
    }
}