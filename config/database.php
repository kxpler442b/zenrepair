<?php

/**
 * Automatically generate database connection configuration from environment.
 * 
 * @author Benjamin Moss <p2595849>
 * 
 * Date: 17/04/23
 */

declare(strict_types = 1);

return [

    'dev_mode' => true,
    'cache_dir' => STORAGE_PATH . '/cache/doctrine',
    'entity_dir' => [APP_PATH . '/Domain'],

    'connection' => function()
    {
        $driver = $_ENV['RSMS_DB_DRIVER'];

        if($driver == 'sqlite')
        {
            return [
                'driver' => 'pdo_sqlite',
                'path' => $_ENV['RSMS_DB_PATH'],
                'user' => $_ENV['RSMS_DB_USER'],
                'password' => $_ENV['RSMS_DB_PASSWORD']
            ];
        }

        if($driver == 'mysql')
        {
            return [
                'driver' => 'pdo_mysql',
                'host' => $_ENV['RSMS_DB_HOST'],
                'port' => $_ENV['RSMS_DB_PORT'],
                'dbname' => $_ENV['RSMS_DB_NAME'],
                'user' => $_ENV['RSMS_DB_USER'],
                'password' => $_ENV['RSMS_DB_PASSWORD']
            ];
        }

        else return null;
    }
];