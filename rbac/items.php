<?php
return [
    'showGoods' => [
        'type' => 2,
        'description' => 'Show goods',
    ],
    'confirmUser' => [
        'type' => 2,
        'description' => 'Confirm user data',
    ],
    'client' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'showGoods',
        ],
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
