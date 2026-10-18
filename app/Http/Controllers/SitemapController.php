<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Event;
use App\Models\Resource;
use Illuminate\Support\Facades\Route;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // ─── STATIC PAGES ───
        $static = [
            ['loc' => route('home'),            'priority' => '1.0',  'changefreq' => 'weekly'],
            ['loc' => route('about'),           'priority' => '0.9',  'changefreq' => 'monthly'],
            ['loc' => route('baptism'),         'priority' => '0.95', 'changefreq' => 'weekly'],
            ['loc' => route('books.index'),     'priority' => '0.9',  'changefreq' => 'weekly'],
            ['loc' => route('resources'),       'priority' => '0.85', 'changefreq' => 'weekly'],
            ['loc' => route('events.index'),    'priority' => '0.9',  'changefreq' => 'daily'],
            ['loc' => route('events.calendar'), 'priority' => '0.8',  'changefreq' => 'daily'],
            ['loc' => route('invite'),          'priority' => '0.85', 'changefreq' => 'monthly'],
            ['loc' => route('contact'),         'priority' => '0.7',  'changefreq' => 'monthly'],
            ['loc' => route('community'),       'priority' => '0.7',  'changefreq' => 'monthly'],
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

        // ─── BOOKS ───
        Book::query()->where('is_published', true)->get()->each(function ($book) use (&$urls) {
            $urls[] = [
                'loc'        => route('books.show', $book->slug),
                'priority'   => '0.85',
                'changefreq' => 'monthly',
                'lastmod'    => $book->updated_at?->toAtomString(),
            ];
        });

        // ─── RESOURCES ───
        Resource::query()->where('is_published', true)->get()->each(function ($resource) use (&$urls) {
            $urls[] = [
                'loc'        => route('resources.show', $resource->slug),
                'priority'   => '0.8',
                'changefreq' => 'monthly',
                'lastmod'    => $resource->updated_at?->toAtomString(),
            ];
        });

        // ─── EVENTS ───
        Event::query()->get()->each(function ($event) use (&$urls) {
            $urls[] = [
                'loc'        => route('events.show', $event->slug),
                'priority'   => '0.75',
                'changefreq' => 'weekly',
                'lastmod'    => $event->updated_at?->toAtomString(),
            ];
        });

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }
}