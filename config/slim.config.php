<?php

/**
 * Slim configuration
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

$slim_config = [
    'settings' => [
        'displayErrorDetails' => True,
        'twig' => [
            'views' => $app_path . '/Views',
            'settings' => [
                'debug' => True,
                'cache' => False
            ],
        ],
    ],
];

return $slim_config;