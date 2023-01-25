<?php

/**
 * Return a pre-built application container instance.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;

$app_config = include_once __DIR__ . '/app.php';

$container = new \Slim\Container($app_config);

$container['entityManager'] = function($container)
{
    $config = ORMSetup::createAttributeMetadataConfiguration(
        paths: [
            APP_PATH . '/Entities'
        ],
        isDevMode: True
    );

    $connection = DriverManager::getConnection([
        'driver' => 'pdo_mysql',
        'host' => $_ENV['DB_HOST'],
        'port' => $_ENV['DB_PORT'],
        'dbname' => $_ENV['DB_NAME'],
        'user' => $_ENV['DB_USER'],
        'pass' => $_ENV['DB_PASS']
    ]);

    return new EntityManager($connection, $config);
};

$container['twig'] = function($container)
{
    $twig = new \Slim\Views\Twig(
        VIEWS_PATH,
        $container['settings']['twig']
    );

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $twig->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $twig;
};

$container[\App\Controllers\HomeController::class] = function($container)
{
    return new \App\Controllers\HomeController($container);
};

return $container;