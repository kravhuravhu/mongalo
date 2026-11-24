<?php

/*
|--------------------------------------------------------------------------
| iN brands
|--------------------------------------------------------------------------
| Every "iN" branch of the ministry (iN Community, a future iN Church, ...)
| is described here. Pages read their name, theme, CTAs and event categories
| from this registry. See docs/v160-in-brands.md for how to add one.
*/

return [
    'default' => 'community',

    'brands' => [
        'community' => [
            'active' => true,
            'name' => 'iN Community',
            'slug' => 'community',
            'route' => 'community',
            'tagline' => 'Blood · Water · Spirit',
            'quote' => 'A movement of faith built on immersion and indwelling. Baptising, praying and equipping believers for a deeper walk and a greater impact.',
            'theme' => [
                'bg' => '#1a080c',
                'surface' => '#3d121a',
                'accent' => '#b8263e',
                'accent_hover' => '#a32036',
                'accent_soft' => '#e89aa7',
                'accent_text' => '#f8a5b3',
            ],
            'cta' => [
                'primary' => ['label' => 'Join on Whatsapp', 'channel' => 'whatsapp'],
                'secondary' => ['label' => 'See Events', 'href' => '#programs'],
            ],
            'event_categories' => [
                'baptism' => ['label' => 'Baptisms', 'pinned' => true],
                'book_tour' => ['label' => 'Book Tours', 'pinned' => true],
                'prayer' => ['label' => 'Prayer Nights', 'pinned' => false],
                'other' => ['label' => 'Events', 'pinned' => false],
            ],
        ],
        
        /*
        | Example for a future brand. Copy, rename, set 'active' => true,
        | then follow docs/v160-in-brands.md:
        |
        | 'church' => [
        |     'active' => false,
        |     'name' => 'iN Church',
        |     'slug' => 'church',
        |     'route' => 'church',
        |     'tagline' => '...',
        |     'quote' => '...',
        |     'theme' => ['bg' => '#...', 'surface' => '#...', 'accent' => '#...', 'accent_hover' => '#...', 'accent_soft' => '#...', 'accent_text' => '#...'],
        |     'cta' => [
        |         'primary' => ['label' => '...', 'channel' => 'whatsapp'],
        |         'secondary' => ['label' => '...', 'href' => '#...'],
        |     ],
        | ],
        */
    ],
];