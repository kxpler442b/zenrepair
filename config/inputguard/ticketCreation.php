<?php

declare(strict_types = 1);

return [
    'required' => [
        'create_form_title', 
        'create_form_status'
    ],
    'integer' => [
        'create_form_status'
    ],
    'length' => [
        ['create_form_status', 1]
    ],
    'lengthMax' =>  [
        ['create_form_title', 50]
    ]
];