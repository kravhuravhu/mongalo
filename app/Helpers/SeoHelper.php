<?php

if (! function_exists('seo_real_social')) {
    /**
     * Returns the URL only if it looks like a real profile
     * (has a path or a query string), otherwise null.
     */
    function seo_real_social(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        $url = trim($url);

        // Must be a URL
        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        $query = parse_url($url, PHP_URL_QUERY);

        // Bare domain (path is '/' or empty AND no query) → treat as unset
        if ((empty($path) || $path === '/') && empty($query)) {
            return null;
        }

        return $url;
    }
}

if (! function_exists('seo_social_array')) {
    /**
     * Returns a filtered array of real social URLs.
     */
    function seo_social_array(): array
    {
        return array_values(array_filter(config('seo.social', [])));
    }
}