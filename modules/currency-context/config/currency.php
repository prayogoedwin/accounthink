<?php

return [
    'base' => env('APP_CURRENCY', 'IDR'),
    'display' => env('DISPLAY_CURRENCY'),
    'stale_after_seconds' => 86400,
    'currencies' => [
        'IDR' => ['minor_units' => 0, 'symbol' => 'Rp'],
        'USD' => ['minor_units' => 2, 'symbol' => '$'],
        'EUR' => ['minor_units' => 2, 'symbol' => '€'],
        'GBP' => ['minor_units' => 2, 'symbol' => '£'],
        'JPY' => ['minor_units' => 0, 'symbol' => '¥'],
        'KWD' => ['minor_units' => 3, 'symbol' => 'د.ك'],
    ],
];
