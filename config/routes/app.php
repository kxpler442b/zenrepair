<?php

/**
 * Registers routes onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controller\WorkshopController;
use App\Http\Controller\DashboardController;

return function (App $app)
{
    $app->group('/dashboard', function(RouteCollectorProxy $dashboard) {

        $dashboard->get('', [DashboardController::class, 'index']);

    })->add(AuthMiddleware::class);

    $app->group('/workshop', function(RouteCollectorProxy $workshop) {

        $workshop->get('', [WorkshopController::class, 'index']);
        
    });
};