<?php

/**
 * Application and dependency settings go here.
 * 
 * @author Benjamin Moss <benmoss2002@fastmail.co.uk>
 * 
 * Date: 05/08/23
 */

declare(strict_types = 1);

use Monolog\Logger;
use DI\ContainerBuilder;
use App\Support\Settings\Settings;
use App\Support\Settings\SettingsInterface;

return function(ContainerBuilder $cb)
{
    $cb->addDefinitions([
        SettingsInterface::class => function() {
            return new Settings([

                /** General Application Settings */
                'app_name' => 'zenrepair',
                'app_version' => '0.2.1',
                'base_url' => $_ENV['APP_BASE_URL'],

                /** Slim Settings */
                'displayErrorDetails' => true,
                'logError' => true,
                'logErrorDetails' => true,

                /** Doctrine (Database) Settings */
                'doctrine' => [
                    'dev_mode' => true,
                    'cache_dir' => __DIR__ . '/../var/cache/doctrine',
                    'entity_dir' => [__DIR__ . '/../src/Domain'],
                    'connection' => [
                        'driver' => 'pdo_pgsql',
                        'host' => $_ENV['DB_HOST'],
                        'port' => $_ENV['DB_PORT'],
                        'dbname' => $_ENV['DB_NAME'],
                        'user' => $_ENV['DB_USER'],
                        'password' => $_ENV['DB_PASS']
                    ]
                ],

                /** Twig (Template Engine) Settings */
                'twig' => [
                    'debug' => true,
                    'cache' => __DIR__ . '/../var/cache/twig',
                    'auto_reload' => true,
                    'templates' => __DIR__ . '/../templates'
                ],

                /** Session Settings */
                'session' => [
                    'name' => 'suprboard-app',
                    'lifetime' => 7200,
                    'path' => null,
                    'domain' => null,
                    'secure' => false,
                    'httponly' => true,
                    'cache_limiter' => 'nocache',
                    'cookie_samesite' => 'Lax',
                    'cookie_secure' => false
                ],

                /** Local Authenticator Settings */
                'localAuthenticator' => [
                    'enforce2fa' => false,
                    'crypto' => [
                        'algo' => PASSWORD_ARGON2ID,
                        'options' => [
                            'memory_cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                            'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                            'threads' => PASSWORD_ARGON2_DEFAULT_THREADS
                        ]
                    ]
                ],

                /** Logger (Monolog) Settings */
                'logger' => [
                    'name' => 'suprboard',
                    'path' => isset($_ENV['DOCKER']) ? 'php://stdout' : __DIR__ . '/../logs/suprboard.log',
                    'level' => Logger::DEBUG
                ]
            ]);
        }
    ]);
};