<?php

/**
 * Return an array containing the application settings.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

return [
    'debugEnabled' => true,
    'displayErrorDetails' => true,
    'logErrors' => false,
    'logErrorDetails' => false,
    'doctrine' => [
        'dev_mode' => true,
        'cache_dir' => STORAGE_PATH . '/cache/doctrine',
        'entity_dir' => [APP_PATH . '/Domain'],
        'connection' => [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
        ]
    ],
    'auth0' => [
        'client_id' => $_ENV['AUTH0_CLIENT_ID'],
        'domain' => $_ENV['AUTH0_DOMAIN'],
        'client_secret' => $_ENV['AUTH0_CLIENT_SECRET'],
        'cookie_secret' => $_ENV['AUTH0_COOKIE_SECRET']
    ],
    'session' => [
        'secure' => false,
        'httponly' => true,
        'samesite' => 'lax'
    ]
];