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

        // ─── XSS PROTECTION (legacy, still useful for older browsers) ───
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // ─── REFERRER POLICY ───
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // ─── STRICT TRANSPORT SECURITY (only over HTTPS) ───
        if ($request->secure()) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains; preload'
            );
        }

        // ─── PERMISSIONS POLICY ───
        $response->headers->set(
            'Permissions-Policy',
            'geolocation=(), microphone=(), camera=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()'
        );

        // ─── PREVENT CACHING OF SENSITIVE PAGES ───
        if ($request->is('admin/*') || $request->is('payment/*') || $request->is('checkout/*')) {
            $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:00 GMT');
        }

        // ─── CONTENT SECURITY POLICY (single source of truth) ───
        $response->headers->set('Content-Security-Policy', $this->buildCsp());

        return $response;
    }

    /**
     * Build the Content-Security-Policy string.
     *
     * Allow-listed third parties:
     *  - Cloudflare Turnstile  (challenges.cloudflare.com)
     *  - Google Analytics 4     (googletagmanager.com, google-analytics.com,
     *                            analytics.google.com, region1.google-analytics.com)
     *  - Google Fonts           (fonts.googleapis.com, fonts.gstatic.com)
     *  - Font Awesome / CDN     (cdnjs.cloudflare.com, cdn.jsdelivr.net)
     *  - Unsplash images        (images.unsplash.com)
     *  - Cloudflare Insights    (static.cloudflareinsights.com)
     */
    private function buildCsp(): string
    {
        $directives = [
            "default-src"     => "'self'",

            "script-src"      => implode(' ', [
                "'self'",
                "'unsafe-inline'",
                "'unsafe-eval'",
                "https://challenges.cloudflare.com",
                "https://www.googletagmanager.com",
                "https://www.google-analytics.com",
                "https://cdnjs.cloudflare.com",
                "https://cdn.jsdelivr.net",
                "https://www.google.com",
                "https://static.cloudflareinsights.com",
            ]),

            "style-src"       => implode(' ', [
                "'self'",
                "'unsafe-inline'",
                "https://fonts.googleapis.com",
                "https://cdnjs.cloudflare.com",
            ]),

            "font-src"        => implode(' ', [
                "'self'",
                "data:",
                "https://fonts.gstatic.com",
                "https://cdnjs.cloudflare.com",
            ]),

            "img-src"         => implode(' ', [
                "'self'",
                "data:",
                "blob:",
                "https:",
                "https://images.unsplash.com",
                "https://www.google-analytics.com",
                "https://www.googletagmanager.com",
                "https://challenges.cloudflare.com",
            ]),

            // ─── `data:` here silences Turnstile's `data:,` probe ───
            // ─── It only permits fetch() to inline data URIs, not code execution ───
            "connect-src"     => implode(' ', [
                "'self'",
                "data:",
                "blob:",
                "https://www.google-analytics.com",
                "https://analytics.google.com",
                "https://region1.google-analytics.com",
                "https://www.googletagmanager.com",
                "https://challenges.cloudflare.com",
                "https://static.cloudflareinsights.com",
            ]),

            "frame-src"       => implode(' ', [
                "'self'",
                "https://challenges.cloudflare.com",
                "https://www.googletagmanager.com",
                "https://www.google.com",
            ]),

            "frame-ancestors" => "'self'",
            "base-uri"        => "'self'",
            "form-action"     => "'self'",
            "object-src"      => "'none'",
            "worker-src"      => "'self' blob:",
            "manifest-src"    => "'self'",
            "media-src"       => "'self'",
        ];

        // Build "directive value; directive value;" string
        $parts = [];
        foreach ($directives as $name => $value) {
            $parts[] = $name . ' ' . $value;
        }

        return implode('; ', $parts);
    }
}