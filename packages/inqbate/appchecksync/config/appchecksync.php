<?php

return [

    'appcheck' => [
        'api_key' => env('APPCHECK_API_KEY', null)
    ],
    'jira' => [

        'username' => env('JIRA_USER', null),
        'password' => env('JIRA_PASS', null),
        'api_key' => env('JIRA_API_KEY', null),
        'host'   => env('JIRA_HOST', ''),

    ],
    'unfuddled' => [
        'username' => env('UNFUDDLED_USERNAME', null),
        'password' => env('UNFUDDLED_PASSWORD', null),
        'ssl'   => env('UNFUDDLED_SSL', true),
    ]
];
