<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => env('APP_TIMEZONE', 'Africa/Johannesburg'),

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'admin_domain' => env('ADMIN_DOMAIN', 'admin.localhost'),

    /*
    |--------------------------------------------------------------------------
    | Banking Details
    |--------------------------------------------------------------------------
    |
    | These settings control banking details shown for payments.
    |
    */
    'bank_name' => env('BANK_NAME', ''),
    'bank_account_name' => env('BANK_ACCOUNT_NAME', ''),
    'bank_account_number' => env('BANK_ACCOUNT_NUMBER', ''),
    'bank_branch_code' => env('BANK_BRANCH_CODE', ''),

    /*
    |--------------------------------------------------------------------------
    | Admin Notification Settings
    |--------------------------------------------------------------------------
    |
    | These settings control admin email notifications for various events.
    |
    */
    'admin_email' => env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', 'admin@example.com')),
    'admin_name' => env('ADMIN_NAME', 'Admin'),

    /*
    |--------------------------------------------------------------------------
    | Contact Settings
    |--------------------------------------------------------------------------
    |
    | These settings control contact information.
    |
    */
    'app_contact_email' => env('CONTACT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    'app_contact_phone' => env('CONTACT_PHONE', '+27 71 461 1401'),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp Community
    |--------------------------------------------------------------------------
    |
    | These settings control the WhatsApp community invite URL.
    |
    */
    'whatsapp_invite_url' => env('WHATSAPP_INVITE_URL', '#'),

    /*
    |--------------------------------------------------------------------------
    | Bot Blocking Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls whether bot blocking is enabled. When enabled,
    | the BotBlocker middleware will block known malicious bots and scrapers.
    |
    */
    'bot_blocking_enabled' => env('BOT_BLOCKING_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting Configuration
    |--------------------------------------------------------------------------
    |
    | This option controls rate limiting for various endpoints.
    |
    */
    'rate_limits' => [
        'enabled' => env('RATE_LIMIT_ENABLED', true),
        'global' => (int) env('RATE_LIMIT_GLOBAL', 60),
        'login' => (int) env('RATE_LIMIT_LOGIN', 5),
        'contact' => (int) env('RATE_LIMIT_CONTACT', 3),
        'contact_get' => (int) env('RATE_LIMIT_CONTACT_GET', 30),
        'baptism' => (int) env('RATE_LIMIT_BAPTISM', 3),
        'invite' => (int) env('RATE_LIMIT_INVITE', 3),
        'payment' => (int) env('RATE_LIMIT_PAYMENT', 10),
        'api' => (int) env('RATE_LIMIT_API', 60),
    ],

];