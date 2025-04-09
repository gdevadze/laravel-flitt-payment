<?php

return [
    'merchant_id' => env('FLITT_MERCHANT_ID', 1549901),

    'secret_key' => env('FLITT_SECRET_KEY', 'test'),

    'callback_url' => env('FLITT_CALLBACK_URL', 'http://myshop/callback/'),

    'response_url' => env('FLITT_RESPONSE_URL'),

    'lang' => env('FLITT_LANG', 'ka'),

    'design_id' => env('FLITT_DESIGN_ID'),

    'currency' => env('FLITT_CURRENCY', 'GEL'),
];
