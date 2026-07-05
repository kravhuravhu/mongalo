<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function index()
    {
        $resources = Book::where('is_free', true)->orderBy('sort_order')->get();
        return view('public.resources.index', compact('resources'));
    }
}