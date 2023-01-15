<?php

/**
 * Registers components onto the Slim container
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

$container['twig'] = function ($container) {
    $twig = new \Slim\Views\Twig($container['settings']['twig']['views'], $container['settings']['twig']['settings']);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $twig->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $twig;
};

$container['logger'] = function ($container) {
    $logger = new \Monolog\Logger('Slim');
    $handle = new \Monolog\Handler\StreamHandler(LOG_PATH . '/slim.log', \Monolog\Logger::DEBUG);

    $logger->pushHandler($handle);

    return $logger;
};

$container[\Doctrine\ORM\EntityManager::class] = function ($container): \Doctrine\ORM\EntityManager {
    $settings = $container->get('settings');

    $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration($settings['doctrine']['metadata_dirs'], $settings['doctrine']['dev_mode']);
    
    $connection = \Doctrine\DBAL\DriverManager::getConnection($settings['doctrine']['connection'], $config);

    return new \Doctrine\ORM\EntityManager($connection, $config);
};

$container['database'] = function ($container) {
    return new \App\Libraries\Database($container, DB_CONFIG);
};

$container['okta'] = function ($container) {
    return new \App\Libraries\OktaApi($container, OKTA_CONFIG);
};

$container['validator'] = function ($container) {
    return new \App\Libraries\Validator($container);
};