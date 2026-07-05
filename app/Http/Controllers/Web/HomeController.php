<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredBook = Book::where('is_featured', true)->first();
        $books = Book::where('is_free', false)->orderBy('sort_order')->limit(3)->get();
        $freeResources = Book::where('is_free', true)->limit(4)->get();
        $upcomingEvents = Event::where('is_past', false)
            ->orderBy('date')
            ->limit(4)
            ->get();

        return view('public.home.index', compact(
            'featuredBook',
            'books',
            'freeResources',
            'upcomingEvents'
        ));
    }
}