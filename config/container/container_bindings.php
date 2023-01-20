<?php

/**
 * Build the container instance.
 * 
 * Author: B Moss
 * Email: <P2595849@my365.dmu.ac.uk>
 * Date: 15/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

return
[
    App::class => function(ContainerInterface $container)
    {
        AppFactory::setContainer($container);

        $middleware = require CONFIG_PATH . '/middleware.php';
        $router = require CONFIG_PATH . '/routes.php';

        $app = AppFactory::create();

        $router($app);
        $middleware($app);

        return $app;
    },

    Twig::class => function(ContainerInterface $container)
    {
        $twig = TwigMiddleware::create(VIEWS_PATH, [
            'cache' => CACHE_PATH,
            'auto_reload' => True
        ]);

        return $twig;
    },


];