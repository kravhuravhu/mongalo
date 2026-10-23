<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class SettingsServiceProvider extends ServiceProvider
{
    // ─── REGISTER ───
    public function register(): void
    {
        require_once app_path('Support/helpers.php');
    }

    // ─── BOOT ───
    public function boot(): void
    {
        // ─── SHARE SETTINGS WITH ALL VIEWS AS $settings ───
        View::composer('*', function ($view) {
            $view->with('settings', Setting::allCached());
        });
    }
}