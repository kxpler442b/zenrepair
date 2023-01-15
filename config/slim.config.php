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

require 'database.config.php';

$slim_settings = [
    "settings" => [
        'displayErrorDetails' => true,
        'determineRouteBeforeAppMiddleware' => false,
        'doctrine' => $doctrine_settings,
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

define('SLIM_SETTINGS', $slim_settings);