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
use App\Http\Action\Web\Devices\ViewDevicesAction;
use App\Http\Action\Web\Tickets\ViewTicketsAction;
use App\Http\Action\Web\Customers\ViewCustomersAction;
use App\Http\Action\Web\Dashboard\ViewDashboardAction;
use App\Http\Action\Web\Settings\ViewUserSettingsAction;

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
        $api->get('/users/get/{id}', GetUserAction::class);
        $api->post('/users/create', CreateUserAction::class);

    })->add(AuthMiddleware::class);

    /**
     * Frontend related routes.
     */
    $app->group('/web', function(RouteCollectorProxy $web) {

        // Dashboard
        $web->get('/dashboard', ViewDashboardAction::class);

        // Tickets
        $web->get('/tickets', ViewTicketsAction::class);
        $web->get('/ticket/{id}', ViewTicketAction::class);

        // Customers
        $web->get('/customers', ViewCustomersAction::class);

        // Devices
        $web->get('/devices', ViewDevicesAction::class);

        // Settings
        $web->get('/settings/user', ViewUserSettingsAction::class);

    })->add(AuthMiddleware::class); // Protected group.
};