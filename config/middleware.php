<?php

/**
 * Registers middleware onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use Slim\Views\TwigMiddleware;
use Slim\Views\Twig;
use App\Config;

return function (App $app)
{
    $container = $app->getContainer();
    // $config = $container->get(Config::class);

    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
};