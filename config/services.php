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
        'client_id' => '1795238914119438',
        'client_secret' => 'a2221006fdbe87bc490ff69502adcd11',
        'redirect' => env('APP_URL').'auth/facebook/callback',
    ],

    'google' => [
        'client_id' => '97425259992-bg3nf4nufvf7b42m1qdji9u53pdfte69.apps.googleusercontent.com',
        'client_secret' => 'HawQPRv5ocK9YWPG2IeluT_o',
        'redirect' => env('APP_URL').'auth/google/callback',
    ],

];
