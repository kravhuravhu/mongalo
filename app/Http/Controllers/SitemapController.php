<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];
        // ─── STATIC PAGES ───
        $static = [
            ['loc' => route('home'),        'priority' => '1.0',  'changefreq' => 'weekly'],
            ['loc' => route('about'),       'priority' => '0.9',  'changefreq' => 'monthly'],
            ['loc' => route('books.index'), 'priority' => '0.9',  'changefreq' => 'weekly'],
            ['loc' => route('resources'),   'priority' => '0.85', 'changefreq' => 'weekly'],
            ['loc' => route('community'),   'priority' => '0.9',  'changefreq' => 'daily'],
            ['loc' => route('invite'),      'priority' => '0.85', 'changefreq' => 'monthly'],
            ['loc' => route('contact'),     'priority' => '0.7',  'changefreq' => 'monthly'],
        ];

        // Legal pages — only if the routes exist
        foreach (['privacy' => '0.3', 'terms' => '0.3'] as $name => $priority) {
            if (Route::has($name)) {
                $static[] = ['loc' => route($name), 'priority' => $priority, 'changefreq' => 'yearly'];
            }
        }

        foreach ($static as $row) {
            $urls[] = $row;
        }

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}