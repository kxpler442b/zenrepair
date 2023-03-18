<?php

/**
 * Registers middleware onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Support\Config;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Interface\SessionInterface;
use App\Middleware\SessionMiddleware;
use App\Middleware\LocalAuthMiddleware;

return function (App $app)
{
    $container = $app->getContainer();

    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));
    $app->add(SessionMiddleware::create($container->get(SessionInterface::class)));
    
    $app->addBodyParsingMiddleware();
};