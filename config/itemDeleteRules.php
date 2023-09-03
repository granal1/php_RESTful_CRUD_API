<?php

return [
    'required' => [
        'id',
    ],
    'pattern' => [
        'id' => '/^[\d]{1,10}$/',
        'name' => '/^.{0,}$/u',
        'phone' => '/^.{0,}$/',
        'key' => '/^.{0,}$/',
        'history' => '/^.{0,}$/u',
        'created_at' => '/^.{0,}$/u',
        'updated_at' => '/^.{0,}$/u',
    ]
];