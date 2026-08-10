<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class CacheClearCommand extends Command
{
    protected $signature = 'cache:clear-all {--keep-session : Keep session cache}';
    protected $description = 'Clear all application cache including page cache, query cache, and view cache';

    public function handle()
    {
        $this->info('Clearing application cache...');

        // ─── CLEAR LARAVEL CACHE ───
        Artisan::call('cache:clear');
        $this->info('✓ Laravel cache cleared');

        // ─── CLEAR VIEW CACHE ───
        Artisan::call('view:clear');
        $this->info('✓ View cache cleared');

        // ─── CLEAR ROUTE CACHE ───
        Artisan::call('route:clear');
        $this->info('✓ Route cache cleared');

        // ─── CLEAR CONFIG CACHE ───
        Artisan::call('config:clear');
        $this->info('✓ Config cache cleared');

        // ─── CLEAR PAGE CACHE ───
        if (!$this->option('keep-session')) {
            Cache::flush();
            $this->info('✓ Full cache flushed');
        } else {
            $this->info('✓ Session cache preserved');
        }

        $this->info('All cache cleared successfully!');
    }
}