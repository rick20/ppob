<?php

return [

    'default' => 'account-mobilepulsa',

    /*
    |--------------------------------------------------------------------------
    | Selenium Service
    |--------------------------------------------------------------------------
    |
    | To create selenium chrome based browser, you must specify its host
    |
    */

    'accounts' => [
        'account-mobilepulsa' => [
            'provider' => 'mobile-pulsa',
            'username' => env('MOBILEPULSA_USERNAME'),
            'apikey' => env('MOBILEPULSA_APIKEY')
        ],
        'account-portalpulsa' => [
            'provider' => 'portal-pulsa',
            'username' => env('PORTALPULSA_USERNAME'),
            'apikey' => env('PORTALPULSA_APIKEY'),
            'secret' => env('MOBILEPULSA_SECRET')
        ],
        'account-tripay' => [
            'provider' => 'tripay',
            'apikey' => env('TRIPAY_APIKEY'),
            'pin' => env('TRIPAY_PIN')
        ],
    ]
];
