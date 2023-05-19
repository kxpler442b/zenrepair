<?php

/**
 * Registers authentication routes.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Controller\AuthController;

return function(App $app)
{
    $app->group('', function(RouteCollectorProxy $auth) {

        $auth->get('/', [AuthController::class, 'index']);
        $auth->get('/logout', [AuthController::class, 'logout']);

        $auth->get('/form/{name}', [AuthController::class, 'getLoginForm']);

        $auth->post('/login', [AuthController::class, 'login']);
    });
};