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
use App\Auth\Middleware\LocalAuthMiddleware;
use App\Http\Controller\WorkshopController;

return function (App $app)
{
    $app->group('/workshop', function(RouteCollectorProxy $workshop) {

        $workshop->get('/view/dashboard', [WorkshopController::class, 'dashboard']);
        $workshop->get('/view/{context}', [WorkshopController::class, 'listView']);
        $workshop->get('/view/{context}/{id}', [WorkshopController::class, 'singleView']);
        $workshop->get('/new/{context}', [WorkshopController::class, 'createView']);
        
    })->add(LocalAuthMiddleware::class);
};