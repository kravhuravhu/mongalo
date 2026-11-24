<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // ─── VALID CATEGORIES ───
    protected array $categories = ['booklet', 'pamphlet', 'bible', 'study_guide', 'other'];
    
    public function books(Request $request)
    {
        return $this->render($request, 'books');
    }

    public function resources(Request $request)
    {
        return $this->render($request, 'resources');
    }

    protected function render(Request $request, string $tab)
    {
        // ─── GET CATEGORY FROM QUERY ───
        $category = $request->get('cat', 'all');

        if ($category !== 'all' && !in_array($category, $this->categories)) {
            $category = 'all';
        }

        // ─── PAID BOOKS ───
        $paidBooks = Book::getCachedPaidBooks();

        // ─── FREE RESOURCES ───
        $resources = Book::where('is_free', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // ─── CATEGORY COUNTS ───
        $counts = ['all' => $resources->count()];
        
        foreach ($this->categories as $key) {
            $counts[$key] = $resources->where('category', $key)->count();
        }
        return view('public.library.v160.index', compact('tab', 'paidBooks', 'resources', 'counts', 'category'));
    }
}
