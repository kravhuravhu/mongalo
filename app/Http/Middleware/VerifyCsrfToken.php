<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // ─── ONLY WEBHOOKS SHOULD BE EXEMPT ───
        'payment/webhook/*',
        '/payment/webhook/*',
        'payment/webhook/payfast',
        'payment/webhook/yoco',
    ];
}