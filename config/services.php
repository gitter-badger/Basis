<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */
    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],
    'mandrill' => [
        'secret' => '',
    ],
    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'eu-central-1',
    ],
    'stripe' => [
        'model'  => 'App\User',
        'key' => '',
        'secret' => '',
    ],
    'hipchat' => [
        'token' => '1c58df69bf93342db66499b35af2f1',
        'room' => '1257206',
        'name' => 'Dev Debug', // Note: HipChat's v1 API supports names up to 15 UTF-8 characters.
        'level' => \Monolog\Logger::DEBUG
    ],
    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI')
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect' => env('TWITTER_REDIRECT_URI')
    ]
];
