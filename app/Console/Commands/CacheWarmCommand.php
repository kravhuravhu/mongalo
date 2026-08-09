<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Book;
use App\Models\Event;
use App\Services\CacheService;

class CacheWarmCommand extends Command
{
    protected $signature = 'cache:warm';
    protected $description = 'Warm up the application cache';

    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        parent::__construct();
        $this->cacheService = $cacheService;
    }

    public function handle()
    {
        $this->info('Warming up cache...');

        // ─── WARM BOOK CACHE ───
        $this->info('Warming book cache...');
        Book::getCachedFeatured();
        Book::getCachedPaidBooks();
        Book::getCachedFreeBooks();
        $this->info('✓ Book cache warmed');

        // ─── WARM EVENT CACHE ───
        $this->info('Warming event cache...');
        Event::getCachedUpcomingEvents();
        Event::getCachedEventsWithRegistrations();
        $this->info('✓ Event cache warmed');

        // ─── WARM STATS CACHE ───
        $this->info('Warming stats cache...');
        $statsKey = $this->cacheService->key('stats', ['dashboard' => true]);
        $this->cacheService->rememberClosure($statsKey, function () {
            return [
                'total_books' => Book::count(),
                'total_events' => Event::count(),
                'total_registrations' => \App\Models\EventRegistration::count(),
                'total_orders' => \App\Models\Order::count(),
                'total_revenue' => \App\Models\Order::where('payment_status', 'paid')->sum('amount'),
            ];
        });
        $this->info('✓ Stats cache warmed');

        $this->info('Cache warmed successfully!');
    }
}