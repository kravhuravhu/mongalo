<?php

/*
|--------------------------------------------------------------------------
| Social / CTA channels
|--------------------------------------------------------------------------
| Leave an env value empty and every <x-v160.cta-link> for that channel opens
| the "coming soon" modal instead of a dead link.
*/

return [
    'channels' => [

        // WhatsApp Community
        'whatsapp' => [
            'label' => 'WhatsApp',
            'noun' => 'community group',
            'icon' => 'fa-brands fa-whatsapp',
            'url' => env('WHATSAPP_INVITE_URL'),
        ],

        // Instagram
        'instagram' => [
            'label' => 'Instagram',
            'noun' => 'page',
            'icon' => 'fa-brands fa-instagram',
            'url' => env('INSTAGRAM_INVITE_URL'),
        ],

        // Facebook Page
        'facebook' => [
            'label' => 'Facebook',
            'noun' => 'page',
            'icon' => 'fa-brands fa-facebook-f',
            'url' => env('FACEBOOK_INVITE_URL'),
        ],

        // YouTube Channel
        'youtube' => [
            'label' => 'YouTube',
            'noun' => 'channel',
            'icon' => 'fa-brands fa-youtube',
            'url' => env('YOUTUBE_INVITE_URL'),
        ],
    ],
];