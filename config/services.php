<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
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

    /*
    |--------------------------------------------------------------------------
    | Evolution API - WhatsApp Integration
    |--------------------------------------------------------------------------
    | Hospedado na VPS Hostinger em:
    | https://evolution.piccininidigitalsolutions.com.br
    */
    'evolution' => [
        'url' => env('EVOLUTION_API_URL', 'https://evolution.piccininidigitalsolutions.com.br'),
        'api_key' => env('EVOLUTION_API_KEY', ''),
        'instance' => env('EVOLUTION_INSTANCE', 'foco_sinalizacao'),
        'admin_number' => env('WHATSAPP_ADMIN_NUMBER', '5551992941111'),
    ],

];
