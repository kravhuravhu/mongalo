<?php

use App\Providers\AppServiceProvider;
use App\Providers\ViewServiceProvider;
use App\Providers\RateLimitServiceProvider;

return [
    AppServiceProvider::class,
    ViewServiceProvider::class,
    RateLimitServiceProvider::class,
];
