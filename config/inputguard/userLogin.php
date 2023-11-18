<?php

declare(strict_types = 1);

return [
    'required' => [
        'username', 
        'password'
    ],
    'alphaNum' => [
        'username'
    ],
    'lengthMax' =>  [
        ['username', 24]
    ]
];