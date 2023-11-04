<?php

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Controller\AuthController;
use App\Http\Controller\TestController;

return function(App $app) 
{
    $app->get('', [AuthController::class, 'doSignpostClient']);

    $app->group('/auth', function(RouteCollectorProxy $auth) {
        $auth->get('/login', [AuthController::class, 'getLoginView']);
        $auth->get('/logout', [AuthController::class, 'doLogoutUser']);

        $auth->post('/login', [AuthController::class, 'doLoginUser']);
    });

    $app->group('/test', function(RouteCollectorProxy $test) {
        $test->get('', [TestController::class, 'testResponse']);
    });
};