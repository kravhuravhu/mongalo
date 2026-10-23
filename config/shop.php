<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Shipping regions & fees
    |--------------------------------------------------------------------------
    | Flat fees in ZAR. Add / remove regions freely — the checkout form
    | and the order summary build themselves from this array.
    */
    'shipping' => [
        'za' => [
            'label' => 'South Africa',
            'fee'   => 80.00,
            'days'  => '3 – 5 business days',
        ],
        'sadc' => [
            'label' => 'SADC (Lesotho, Zimbabwe, Zambia, Botswana, Namibia, Eswatini, Malawi, Mozambique)',
            'fee'   => 180.00,
            'days'  => '10 – 21 business days',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */
    'currency' => 'R',
];