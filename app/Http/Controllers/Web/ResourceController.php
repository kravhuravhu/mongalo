<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;

class ResourceController extends Controller
{
    public function show($slug)
    {
        // ─── FIND RESOURCE ───
        $resource = Book::where('slug', $slug)->where('is_free', true)->firstOrFail();
        // ─── OPEN IT IN THE LIBRARY MODAL ───
        return redirect()->route('resources', ['open' => $resource->slug], 301);
    }
}