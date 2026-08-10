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

        // ─── CONTENT SECURITY POLICY ───
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; " .
            "script-src 'self' 'unsafe-inline' https://cdnjs.cloudflare.com https://www.google.com https://cdn.jsdelivr.net; " .
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; " .
            "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; " .
            "img-src 'self' data: https:; " .
            "connect-src 'self'; " .
            "frame-src 'self' https://www.google.com; " .
            "object-src 'none'; " .
            "base-uri 'self';"
        );

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