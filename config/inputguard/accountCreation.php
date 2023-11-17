<?php

declare(strict_types = 1);

return [
    'required' => [
        'create_form_username', 
        'create_form_password'
    ],
    'optional' => [
        'create_form_email',
        'create_form_given_name',
        'create_form_family_name'
    ],
    'email' => [
        'create_form_email'
    ],
    'alphaNum' => [
        'create_form_username', 
        'create_form_given_name', 
        'create_form_family_name'
    ],
    'lengthMax' =>  [
        ['create_form_username', 24]
    ]
];