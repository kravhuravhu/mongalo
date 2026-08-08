<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Payment Gateway
    |--------------------------------------------------------------------------
    |
    | This option defines the default payment gateway that will be used by
    | the application. You can change this value to switch to a different
    | gateway at runtime.
    |
    */
    'default_gateway' => env('PAYMENT_DEFAULT_GATEWAY', 'payfast'),

    /*
    |--------------------------------------------------------------------------
    | Available Payment Gateways
    |--------------------------------------------------------------------------
    |
    | Here you can list all the payment gateways that are available for use
    | in your application. Each gateway must implement the PaymentGatewayInterface.
    |
    */
    'gateways' => [
        'payfast' => App\Services\PaymentGateways\PayFastGateway::class,
        // ─── YOCO ───
        // 'yoco' => App\Services\PaymentGateways\YocoGateway::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Define the currency used for all payments in the application.
    |
    */
    'currency' => env('PAYMENT_CURRENCY', 'ZAR'),

    /*
    |--------------------------------------------------------------------------
    | Sandbox / Test Mode
    |--------------------------------------------------------------------------
    |
    | When in sandbox mode, no real transactions are processed.
    |
    */
    'sandbox' => env('PAYMENT_SANDBOX', true),

    /*
    |--------------------------------------------------------------------------
    | Payment Routes
    |--------------------------------------------------------------------------
    |
    | Define the route names for payment-related pages.
    |
    */
    'routes' => [
        'checkout' => 'payment.checkout',
        'return' => 'payment.return',
        'cancel' => 'payment.cancel',
        'webhook' => 'payment.webhook',
        'download' => 'payment.download',
    ],
];