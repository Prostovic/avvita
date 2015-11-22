<?php
return [
    'confirmUser' => [
        'type' => 2,
        'description' => 'Confirm user data',
    ],
    'operator' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'confirmUser',
        ],
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'operator',
        ],
    ],
];
