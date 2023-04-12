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
            'driver' => 'pdo_mysql',
            'host' => $_ENV['MARIADB_HOST'],
            'port' => $_ENV['MARIADB_PORT'],
            'dbname' => $_ENV['MARIADB_DATABASE_NAME'],
            'user' => $_ENV['MARIADB_USER'],
            'password' => $_ENV['MARIADB_PASSWORD']
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