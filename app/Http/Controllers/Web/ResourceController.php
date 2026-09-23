<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // ─── VALID CATEGORIES ───
    protected array $categories = ['booklet', 'pamphlet', 'bible', 'study_guide', 'other'];

    public function index(Request $request)
    {
        // ─── GET CATEGORY FROM QUERY ───
        $category = $request->get('cat', 'all');

        if ($category !== 'all' && !in_array($category, $this->categories)) {
            $category = 'all';
        }

        // ─── QUERY ───
        $query = Book::where('is_free', true);

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $resources = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        // ─── CATEGORY COUNTS ───
        $counts = [
            'all' => Book::where('is_free', true)->count(),
            'booklet' => Book::where('is_free', true)->where('category', 'booklet')->count(),
            'pamphlet' => Book::where('is_free', true)->where('category', 'pamphlet')->count(),
            'bible' => Book::where('is_free', true)->where('category', 'bible')->count(),
            'study_guide' => Book::where('is_free', true)->where('category', 'study_guide')->count(),
            'other' => Book::where('is_free', true)->where('category', 'other')->count(),
        ];

        return view('public.resources.v150.index', compact('resources', 'counts', 'category'));
    }

    public function show($slug)
    {
        // ─── FIND RESOURCE ───
        $resource = Book::where('slug', $slug)->where('is_free', true)->firstOrFail();

        // ─── RELATED RESOURCES (same category) ───
        $relatedResources = Book::where('is_free', true)
            ->where('id', '!=', $resource->id)
            ->where('category', $resource->category)
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('public.resources.v150.show', compact('resource', 'relatedResources'));
    }
}