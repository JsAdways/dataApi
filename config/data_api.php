<?php

return [
    'repository_version' => env('REPOSITORY_VERSION',1),
    'hr_host' => env('JS_AUTH_HOST'),
    'fix_host' => [
        'n8n' => env('N8N_HOST','http://35.201.208.145:5678')
    ],
    'fetch_api_url' => '/api/data_api/fetch',
    'get_api_url' => '/api/data_api/get'
];
