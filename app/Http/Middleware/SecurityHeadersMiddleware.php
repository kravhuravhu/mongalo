<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // ─── PREVENT MIME TYPE SNIFFING ───
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // ─── PREVENT CLICKJACKING ───
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // ─── XSS PROTECTION ───
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ─── REFERRER POLICY ───
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ─── PREVENT CACHING OF SENSITIVE PAGES ───
        if ($request->is('admin/*') || $request->is('payment/*') || $request->is('checkout/*')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        }

        // ─── PERMISSIONS POLICY ───
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=(), payment=()');

        return $response;
    }
}