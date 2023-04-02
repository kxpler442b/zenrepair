<?php

/**
 * Guardian (auth) routes
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 28/03/23
 */

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\GuardianController;

return function(App $app)
{
    $app->group('/', function (RouteCollectorProxy $auth) {
        $auth->get('login', [GuardianController::class, 'getUserLoginView']);
        $auth->get('logout', [GuardianController::class, 'doSignOutUser']);
        
        $auth->post('login', [GuardianController::class, 'doSignInUser']);
    });
};