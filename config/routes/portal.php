<?php

/**
 * Registers customer portal routes onto the Slim application.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 24/03/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Controller\PortalController;
use Slim\Routing\RouteCollectorProxy;

return function(App $app)
{
    $app->group('/portal', function(RouteCollectorProxy $portal)
    {
        $portal->get('', [PortalController::class, 'getLoginView']);
        $portal->get('/overview', [PortalController::class, 'getListView']);

        $portal->post('', [PortalController::class, 'handleLogin']);
    });
};