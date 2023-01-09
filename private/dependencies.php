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

$container['database'] = function ($container) {
    return new \App\Libraries\Database($container, DB_CONFIG);
};

$container['AuthController'] = function ($c) {
    return new \App\Controllers\AuthController($c);
};