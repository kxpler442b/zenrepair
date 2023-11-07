<?php

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Auth\DoLoginAction;
use App\Http\Action\Auth\ViewLoginAction;
use App\Http\Action\Auth\DoSignpostAction;
use App\Http\Action\User\CreateUserAction;
use App\Http\Action\Dashboard\ViewDashboardAction;

return function(App $app) 
{
    $app->get('', DoSignpostAction::class);

    $app->group('/auth', function(RouteCollectorProxy $auth) {
        $auth->get('/login', ViewLoginAction::class);
        $auth->get('/logout', [AuthController::class, 'doLogoutUser']);

        $auth->post('/login', DoLoginAction::class);
    });

    $app->group('/users', function(RouteCollectorProxy $users) {
        $users->post('/create', CreateUserAction::class);
    });

    $app->get('/dashboard', ViewDashboardAction::class);
};