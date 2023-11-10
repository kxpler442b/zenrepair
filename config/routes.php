<?php

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Auth\DoLoginAction;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Action\Auth\DoLogoutAction;
use App\Http\Action\Auth\ViewLoginAction;
use App\Http\Action\Auth\DoSignpostAction;
use App\Http\Action\Auth\DoTfaLoginAction;
use App\Http\Action\Auth\ViewTfaLoginAction;
use App\Http\Action\Api\User\CreateUserAction;
use App\Http\Action\Web\Tickets\ViewTicketsAction;
use App\Http\Action\Web\Dashboard\ViewDashboardAction;

/**
 * Route strategy defenitions.
 */
return function(App $app) 
{
    /**
     * Authentication related routes.
     */
    $app->group('', function(RouteCollectorProxy $auth) {
        $auth->get('/', DoSignpostAction::class);
        $auth->get('/login', ViewLoginAction::class);
        $auth->get('/twostep', ViewTfaLoginAction::class);
        $auth->get('/logout', DoLogoutAction::class);

        $auth->post('/login', DoLoginAction::class);
        $auth->post('/twostep', DoTfaLoginAction::class);
    });

    /**
     * Api related routes.
     */
    $app->group('/api', function(RouteCollectorProxy $api) {

        // Users
        $api->get('/users/{id}', GetUserAction::class);
        $api->post('/users/create', CreateUserAction::class);

    })->add(AuthMiddleware::class); // Protected group.

    /**
     * Frontend related routes.
     */
    $app->group('/web', function(RouteCollectorProxy $web) {

        // Dashboard
        $web->get('/dashboard', ViewDashboardAction::class);

        // Tickets
        $web->get('/tickets', ViewTicketsAction::class);
        $web->get('/ticket/{id}', ViewTicketAction::class);

    })->add(AuthMiddleware::class); // Protected group.
};