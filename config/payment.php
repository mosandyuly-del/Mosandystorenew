<?php
return [
    'mode' => env('PAYMENT_MODE', 'manual'),
    'qris_provider' => env('QRIS_PROVIDER'),
    'qris_api_url' => env('QRIS_API_URL'),
    'qris_api_key' => env('QRIS_API_KEY'),
];
