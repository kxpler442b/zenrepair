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

return function (App $app)
{
    $app->group('/workshop', function(RouteCollectorProxy $workshop) {

        $workshop->get('/dashboard', [WorkshopController::class, 'dashboard']);
        $workshop->get('/{context}', [WorkshopController::class, 'listView']);
        $workshop->get('/{context}/{id}', [WorkshopController::class, 'singleView']);
        
    })->add(AuthMiddleware::class);
};