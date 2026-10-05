<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;
use App\Providers\RateLimitServiceProvider;
use App\Providers\SettingsServiceProvider;

return [
    AppServiceProvider::class,
    ViewServiceProvider::class,
    RateLimitServiceProvider::class,
    SettingsServiceProvider::class
];
