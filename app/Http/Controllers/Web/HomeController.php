<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Event;
use App\Services\CacheService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        // ─── GET CACHED DATA ───
        $cacheKey = $this->cacheService->key('home', ['page' => 'index']);
        
        $data = $this->cacheService->rememberClosure($cacheKey, function () {
            return [
                'featuredBook' => Book::getCachedFeatured(),
                'books' => Book::getCachedPaidBooks(),
                'freeResources' => Book::getCachedFreeBooks(),
                'upcomingEvents' => Event::getCachedUpcomingEvents()->take(4),
            ];
        });

        return view('public.home.index', $data);
    }
}