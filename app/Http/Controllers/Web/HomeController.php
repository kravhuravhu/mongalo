<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;

class HomeController extends Controller
{
    public function index()
    {
        // ─── EACH DATA SOURCE CACHES ITS OWN ID LIST VIA QueryCacheable ───
        // ─── Models are hydrated fresh on every request ───
        $data = [
            'books' => Book::getCachedPaidBooks(),
        ];
        return view('public.home.v160.index', $data);
    }
}