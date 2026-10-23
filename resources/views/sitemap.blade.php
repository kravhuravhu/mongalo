{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    @foreach($urls as $url)
        <url>
            <loc>{{ $url['loc'] }}</loc>
            @if(!empty($url['lastmod']))
                <lastmod>{{ $url['lastmod'] }}</lastmod>
            @endif
            <changefreq>{{ $url['changefreq'] ?? 'weekly' }}</changefreq>
            <priority>{{ $url['priority'] ?? '0.5' }}</priority>
            <xhtml:link rel="alternate" hreflang="en-ZA" href="{{ $url['loc'] }}" />
            <xhtml:link rel="alternate" hreflang="x-default" href="{{ $url['loc'] }}" />
        </url>
    @endforeach
</urlset>