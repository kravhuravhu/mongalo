@php
    $siteName    = config('seo.site_name');
    $siteUrl     = rtrim(config('seo.site_url'), '/');
    $logoUrl     = config('seo.logo');
    $phone       = config('seo.phone_raw');
    $email       = config('seo.email');
    $region      = config('seo.region');
    $countryCode = config('seo.country');
    $lat         = (float) config('seo.latitude');
    $lng         = (float) config('seo.longitude');
    $founded     = config('seo.founding_year');

    // Filter real social URLs (bare domains get removed)
    $sameAs = seo_social_array();

    // ─── ORGANIZATION ───
    $organization = [
        '@type'        => 'Organization',
        '@id'          => $siteUrl . '/#organization',
        'name'         => $siteName,
        'alternateName'=> 'IN.iN Ministry',
        'url'          => $siteUrl,
        'logo'         => [
            '@type' => 'ImageObject',
            'url'   => $logoUrl,
        ],
        'description'  => config('seo.default_description'),
        'founder'      => ['@type' => 'Person', 'name' => 'Arthur Mongalo'],
        'foundingDate' => $founded,
        'areaServed'   => ['@type' => 'Country', 'name' => config('seo.country_name')],
        'contactPoint' => [
            '@type'            => 'ContactPoint',
            'telephone'        => $phone,
            'contactType'      => 'customer service',
            'email'            => $email,
            'availableLanguage'=> ['English'],
        ],
    ];
    if (! empty($sameAs)) {
        $organization['sameAs'] = $sameAs;
    }

    // ─── LOCAL BUSINESS ───
    $localBusiness = [
        '@type'       => 'LocalBusiness',
        '@id'         => $siteUrl . '/#localbusiness',
        'name'        => $siteName,
        'image'       => $logoUrl,
        'url'         => $siteUrl,
        'telephone'   => $phone,
        'email'       => $email,
        'priceRange'  => config('seo.price_range'),
        'address'     => [
            '@type'          => 'PostalAddress',
            'addressRegion'  => $region,
            'addressCountry' => $countryCode,
        ],
        'geo'         => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $lat,
            'longitude' => $lng,
        ],
        'openingHoursSpecification' => [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
            'opens'     => '08:00',
            'closes'    => '18:00',
        ],
    ];

    // ─── WEBSITE ───
    $website = [
        '@type'       => 'WebSite',
        '@id'         => $siteUrl . '/#website',
        'url'         => $siteUrl,
        'name'        => $siteName,
        'description' => 'Baptism ministry and free Christian literature by Arthur Mongalo.',
        'publisher'   => ['@id' => $siteUrl . '/#organization'],
        'inLanguage'  => 'en-ZA',
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => $siteUrl . '/search?q={search_term_string}',
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    // ─── PERSON (Arthur) ───
    $person = [
        '@type'      => 'Person',
        '@id'        => $siteUrl . '/#arthur-mongalo',
        'name'       => 'Arthur Mongalo',
        'jobTitle'   => 'Ordained Pastor, Author',
        'url'        => $siteUrl . '/about',
        'worksFor'   => ['@id' => $siteUrl . '/#organization'],
        'knowsAbout' => ['Water Baptism','Spirit Baptism','Christian Ministry','Divine Identity','New Covenant'],
        'address'    => [
            '@type'          => 'PostalAddress',
            'addressRegion'  => $region,
            'addressCountry' => $countryCode,
        ],
    ];

    // ─── FINAL GRAPH ───
    $graph = [
        '@context' => 'https://schema.org',
        '@graph'   => [$organization, $localBusiness, $website, $person],
    ];
@endphp
<script type="application/ld+json">{!! json_encode($graph, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>