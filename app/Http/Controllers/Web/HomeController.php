<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // ─── EACH DATA SOURCE CACHES ITS OWN ID LIST VIA QueryCacheable ───
        // ─── Models are hydrated fresh on every request ───
        $data = [
            'featuredBook' => Book::getCachedFeatured(),
            'books' => Book::getCachedPaidBooks(),
            'freeResources' => Book::getCachedFreeBooks(),
            'upcomingEvents' => Event::getCachedUpcomingEvents()->take(4),
        ];

        return view('public.home.v150.index', $data);
    }
}