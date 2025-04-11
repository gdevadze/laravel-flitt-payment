<?php

return [
    'merchant_id' => env('FLITT_MERCHANT_ID', 1549901),

    'secret_key' => env('FLITT_SECRET_KEY', 'test'),

    'currency' => env('FLITT_CURRENCY', 'GEL'),

    'callback_url' => env('FLITT_CALLBACK_URL', 'http://myshop/callback/'),

    'response_url' => env('FLITT_RESPONSE_URL'),

    'lang' => env('FLITT_LANG', 'ka'),

    'design_id' => env('FLITT_DESIGN_ID'),

    'auto_order_id' => env('FLITT_AUTO_ORDER_ID', true),
];
