<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// ─── SCHEDULED CACHE CLEANUP ───
Schedule::command('cache:clear-all --keep-session')->daily();

// ─── SCHEDULED CACHE WARMING ───
Schedule::command('cache:warm')->hourly();

// ─── SCHEDULED OLD CACHE CLEANUP ───
Schedule::command('cache:prune-stale-tags')->daily();