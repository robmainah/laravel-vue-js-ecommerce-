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
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'paypal' => [
        'id' => env('PAYPAL_ID'),
        'secret' => env('PAYPAL_SECRET'),
        'url' => [
            'redirect' => 'http://localhost:8000/paypal-execute',
            'cancel' => 'http://localhost:8000/cancel-payment',
            'executeAgreement' => [
                'success' => 'http://localhost:8000/execute-agreement/true',
                'failure' => 'http://localhost:8000/execute-agreement/false',
            ]
        ]
    ],
    // 'mpesa' => [
    //     'callbackUrl' => 'http://03ebd4f7.ngrok.io/mpesa/callback'
    // ]

    //    'stripe' => [
    //        'model' => App\User::class,
    //        'key' => env('STRIPE_KEY'),
    //        'secret' => env('STRIPE_SECRET'),
    //        'webhook' => [
    //            'secret' => env('STRIPE_WEBHOOK_SECRET'),
    //            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
    //        ],
    //    ],

];