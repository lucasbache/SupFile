<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'facebook' => [
        'client_id'     => '957394857747831',
        'client_secret' => '63251063a862ff5fe81dae508f1b5172',
        'redirect'      => 'https://supfile.azurewebsites.net/login/facebook/callback',
    ],
    'twitter' => [
        'client_id'     => 'LsorqOlhthz3DfFuAFvZJBDZT',
        'client_secret' => 'Jz1SMnXt1FCFOWJUSkjIoLx6s4eUlnfHWFH6R1T779bSDGGMEU',
        'redirect'      => 'https://supfile.azurewebsites.net/login/twitter/callback',
    ],
    'google' => [
        'client_id'     => '988341530128-u5pnifam9eeeb317okk8t8h6l8jamfic.apps.googleusercontent.com',
        'client_secret' => 'K26xXhjP2QHS7hZ4dzx13FIt',
        'redirect'      => 'https://supfile.azurewebsites.net/login/google/callback',
    ],
];