<?php

/**
 * dependencies.php
 * 
 * registers components onto the Slim container
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig($container['settings']['view']['views'], [
        'cache' => false,
        'displayErrorDetails' => true
    ]);

    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['AuthController'] = function($c) {
    return new \App\Controllers\AuthController($c);
};

$container['PortalController'] = function($c) {
    return new \App\Controllers\PortalController($c);
};