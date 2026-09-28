<?php
return [
    'username' => env('DIGIFLAZZ_USERNAME'),
    'development_key' => env('DIGIFLAZZ_DEVELOPMENT_KEY'),
    'production_key' => env('DIGIFLAZZ_PRODUCTION_KEY'),
    'mode' => env('DIGIFLAZZ_MODE', 'development'),
    'price_url' => env('DIGIFLAZZ_PRICE_URL'),
    'transaction_url' => env('DIGIFLAZZ_TRANSACTION_URL'),
    'balance_url' => env('DIGIFLAZZ_BALANCE_URL'),
    'webhook_secret' => env('DIGIFLAZZ_WEBHOOK_SECRET'),
];
