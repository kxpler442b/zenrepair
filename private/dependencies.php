<?php

/**
 * Registers dependencies onto the Slim container instance.
 * 
 * Author: B Moss
 * Date: 20/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

use App\Controllers\AuthController;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$container['logger'] = function ($container) : Monolog\Logger {
    $logger = new \Monolog\Logger($container['settings']['logger']['name']);

    $handler = new \Monolog\Handler\StreamHandler($container['settings']['logger']['path']);
    $logger->pushHandler($handler);

    return $logger;
};

$container['entityManager'] = function ($container) : EntityManager {
    $settings = $container['settings']['doctrine'];

    $config = ORMSetup::createAttributeMetadataConfiguration($settings['metadata_dirs'], $settings['dev_mode']);
    $connection = DriverManager::getConnection($settings['connection'], $config);
    
    return new EntityManager($connection, $config);
};

$container['twig'] = function ($container) {
    $twig = new \Slim\Views\Twig($container['settings']['twig']['views'], $container['settings']['twig']['settings']);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $twig->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $twig;
};

$container[\App\Controllers\AuthController::class] = function ($container) : \App\Controllers\AuthController
{
    return new \App\Controllers\AuthController($container);
};