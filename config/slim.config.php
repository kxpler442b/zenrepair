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

 $slim_settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => false,
        'twig' => [
            'views' => $app_path . '/Views',
            'settings' => [
                'cache' => false,
                'displayErrorDetails' => true
            ],
        ],
        'logger' => [
            'name' => 'SLIM',
            'level' => 'None',
            'path' => __DIR__ . '/../logs/app.log'
        ]
    ]
];

return $slim_config;