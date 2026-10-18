<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site identity
    |--------------------------------------------------------------------------
    */
    'site_name' => env('PROJECT_NAME', 'Blood Water Spirit'),
    'site_tagline' => 'I am IN Him // He is IN me',
    'site_url' => rtrim(env('APP_URL', 'http://localhost'), '/'),
    'logo' => env('APP_URL', '') . '/images/blood_water_spirit_Logo-Photoroom.png',

    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    */
    'email' => env('ADMIN_EMAIL', 'admin@bloodwaterspirit.com'),
    'phone' => env('CONTACT_PHONE', '+27 71 461 1401'),
    'phone_raw'=> preg_replace('/[^0-9+]/', '', env('CONTACT_PHONE', '+27714611401')),

    /*
    |--------------------------------------------------------------------------
    | Default meta
    |--------------------------------------------------------------------------
    */
    'default_description' => 'A ministry of baptisms and equipping believers. Led by Arthur Mongalo, ordained pastor in Gauteng, South Africa. Water baptism, Spirit baptism, free Christian literature and community.',

    'default_keywords' => env('SEO_DEFAULT_KEYWORDS',
        'baptism, water baptism, spirit baptism, Arthur Mongalo, Christian ministry South Africa, Blood Water Spirit, free Christian books, Divine Identity, My Salvation Companion'
    ),

    'default_image' => env('APP_URL', '') . '/images/blood_water_spirit_Logo-Photoroom.png',

    'twitter_handle' => env('SEO_TWITTER_HANDLE', ''),

    /*
    |--------------------------------------------------------------------------
    | Organization / LocalBusiness
    |--------------------------------------------------------------------------
    */
    'founding_year' => env('SEO_FOUNDING_YEAR', '2025'),
    'latitude' => (float) env('SEO_LATITUDE', -26.2041),
    'longitude' => (float) env('SEO_LONGITUDE', 28.0473),
    'ga_id' => env('GA_MEASUREMENT_ID', ''),
    'region' => 'Gauteng',
    'country' => 'ZA',
    'country_name' => 'South Africa',
    'price_range' => 'Free',

    /*
    |--------------------------------------------------------------------------
    | Social profiles — each returns null if it's just a bare domain
    |--------------------------------------------------------------------------
    | We treat 'https://facebook.com/' (bare domain, no path/username)
    | as "not configured" so it never pollutes the JSON-LD.
    */
    'social' => [
        'facebook' => seo_real_social(env('FACEBOOK_INVITE_URL', '')),
        'instagram' => seo_real_social(env('INSTAGRAM_INVITE_URL', '')),
        'youtube' => seo_real_social(env('YOUTUBE_INVITE_URL', '')),
        'whatsapp' => seo_real_social(env('WHATSAPP_INVITE_URL', '')),
    ],

];