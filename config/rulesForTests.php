<?php

return [
    'required' => [
        'id',
    ],
    'pattern' => [
        'id' => '/^[\d]{1,10}$/',
        'name' => '/^[А-Яа-яЁёa-zA-Z0-9\s\%20]{0,255}$/u',
        'phone' => '/^[\w\s()-]{0,15}$/',
        'key' => '/^(?!null)[\w\s]{1,20}$/',
        'history' => '/^!.{0,}$/u',
        'created_at' => '/^!.{0,}$/u',
        'updated_at' => '/^!.{0,}$/u',
    ]
];