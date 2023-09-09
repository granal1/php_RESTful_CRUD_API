<?php

return [
    'id' => '/^[\d]{1,10}$/',
    'name' => '/^[А-Яа-яЁёa-zA-Z0-9\s\%20]{0,255}$/u',
    'phone' => '/^[\w\s()-]{0,15}$/',
    'key' => '/^(?!null)[\w\s]{1,20}$/',
    'history' => '/^[А-Яа-яЁёa-zA-Z0-9\s\%20\\\"\,\+\:\-\_\[\{\(\]\}\)]{0,}$/u',
    'created_at' => '/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]) ([0-1]\d|2[0-3])(:[0-5]\d){2}$/',
    'updated_at' => '/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]) ([0-1]\d|2[0-3])(:[0-5]\d){2}$/',
    'deleted_at' => '/^[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01]) ([0-1]\d|2[0-3])(:[0-5]\d){2}$/',
];