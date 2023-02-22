<?php

/**
 * Registers middleware onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Config;
use App\Middleware\LocalAuthMiddleware;
use App\Middleware\SessionMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return function (App $app)
{
    $container = $app->getContainer();
    $config = $container->get(Config::class);

    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
    $app->add(SessionMiddleware::class);
    $app->add(LocalAuthMiddleware::class);
};