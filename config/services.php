<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'ipaymu' => [
        'sandbox' => env('IPAYMU_SANDBOX', true),
        'va' => env('IPAYMU_VA'),
        'api_key' => env('IPAYMU_API_KEY'),
        
        // Auto-switch base URL based on sandbox mode
        'base_url' => env('IPAYMU_SANDBOX', true) 
            ? 'https://sandbox.ipaymu.com/api/v2'  // Sandbox URL
            : 'https://my.ipaymu.com/api/v2',      // Production URL
        
        // Sandbox credentials (for testing)
        'sandbox_va' => env('IPAYMU_SANDBOX_VA'),
        'sandbox_api_key' => env('IPAYMU_SANDBOX_API_KEY'),
        
        // Production credentials
        'production_va' => env('IPAYMU_PRODUCTION_VA'),
        'production_api_key' => env('IPAYMU_PRODUCTION_API_KEY'),
    ],

    // // config/services.php
    // 'midtrans' => [
    //     'serverKey' => env('MIDTRANS_SERVER_KEY'),
    //     'clientKey' => env('MIDTRANS_CLIENT_KEY'),
    //     'isProduction' => env('MIDTRANS_IS_PRODUCTION', false),
    //     'isSanitized' => env('MIDTRANS_IS_SANITIZED', true),
    //     'is3ds' => env('MIDTRANS_IS_3DS', true),
    // ],


];
