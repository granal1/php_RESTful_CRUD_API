<?php

return [
    'required' => [
        'key',
    ],
    'pattern' => [
        'name' => '/^[А-Яа-яЁёa-zA-Z0-9\s\%20]{0,255}$/u',
        'phone' => '/^[\w\s()-]{0,15}$/',
        'key' => '/^(?!null)[\w\s]{1,20}$/',
        'history' => '/^!.{0,}$/u',
        'created_at' => '/^!.{0,}$/u',
        'updated_at' => '/^!.{0,}$/u',
    ]
];