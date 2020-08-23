<?php
return [
    'telescope' => [
        'authorized_emails' => [
            env('TELESCOPE_USER_EMAIL', null)
        ]
    ],
    'cache' => [
        'timeout' => 10
    ],
    'pagination' => [
        'per_page' => 10,
        'per_page_list' => [
            10, 25, 50, 100
        ]
    ],
    'collection' => [
        'chunk_threshold' => 200
    ],
    'misc' => [
        'tz' => 'Asia/Manila'
    ]
];
