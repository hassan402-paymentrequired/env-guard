<?php

return [

    'log_rejections' => false,

    'log_channel' => 'stack',

    'accepted_validation_rules' => [
        'required',
        'string',
        'integer',
        'min:',
        'in:',
        'starts_with:',
        'nullable',
        'boolean'
    ],

    'rules' => [
        // 'APP_KEY' => 'required|string',
        // 'APP_ENV' => 'required|in:local,staging,production',
        // 'DB_PASSWORD' => 'required|string|min:8',
        // 'STRIPE_SECRET' => 'required|starts_with:sk_',
        // 'CACHE_TTL' => 'required|integer|min:1',
        // 'MAIL_PORT' => 'nullable|integer',
    ],
];
