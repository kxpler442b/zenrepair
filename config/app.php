<?php

/**
 * Return an array containing the application settings.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

return [
    'displayErrorDetails' => true,
    'logErrors' => false,
    'logErrorDetails' => false,
    'doctrine' => [
        'dev_mode' => true,
        'cache_dir' => STORAGE_PATH . '/cache/doctrine',
        'entity_dir' => [APP_PATH . '/Domain'],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS']
        ]
    ],
    'session' => [
        'secure' => true,
        'httponly' => true,
        'samesite' => 'lax'
    ],
    'redis' => [
        'host' => $_ENV['REDIS_HOST'],
        'port' => $_ENV['REDIS_PORT'],
        'password' => $_ENV['REDIS_PASSWORD']
    ]
];