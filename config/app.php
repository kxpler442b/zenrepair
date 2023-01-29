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
    'okta' => [
        'client_id' => $_ENV['OKTA_CLIENT_ID'],
        'client_secret' => $_ENV['OKTA_CLIENT_SECRET'],
        'redirect_uri' => $_ENV['OKTA_REDIRECT_URI'],
        'metadata_url' => $_ENV['OKTA_METADATA_URL'],
        'api_base_url' => $_ENV['OKTA_API_BASE_URL']
    ],
    'doctrine' => [
        'dev_mode' => true,
        'cache_dir' => STORAGE_PATH . '/cache/doctrine',
        'entity_dir' => [APP_PATH . '/Entities'],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS']
        ]
    ]
];