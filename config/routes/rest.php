<?php

/**
 * Registers routes onto the Slim application instance.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Controller\UserController;
use App\Http\Middleware\AuthMiddleware;

return function(App $app)
{
    $app->group('users', function(RouteCollectorProxy $users) {

        $users->get('', [UserController::class, 'index']);
        $users->get('/new', [UserController::class, 'new']);
        $users->get('/{id}', [UserController::class, 'show']);
        $users->get('/{id}/edit', [UserController::class, 'edit']);
        
        $users->post('/create', [UserController::class, 'create']);

        $users->put('/update', [UserController::class, 'update']);

        $users->delete('/delete', [UserController::class, 'delete']);

    })->add(AuthMiddleware::class);

    $app->group('customers', function(RouteCollectorProxy $customers) {

        $customers->get('', [CustomerController::class, 'index']);
        $customers->get('/new', [CustomerController::class, 'new']);
        $customers->get('/{id}', [CustomerController::class, 'show']);
        $customers->get('/{id}/edit', [CustomerController::class, 'edit']);
        
        $customers->post('/create', [CustomerController::class, 'create']);

        $customers->put('/update', [CustomerController::class, 'update']);

        $customers->delete('/delete', [CustomerController::class, 'delete']);

    })->add(AuthMiddleware::class);

    $app->group('tickets', function(RouteCollectorProxy $tickets) {

        $tickets->get('', [TicketController::class, 'index']);
        $tickets->get('/new', [TicketController::class, 'new']);
        $tickets->get('/{id}', [TicketController::class, 'show']);
        $tickets->get('/{id}/edit', [TicketController::class, 'edit']);
        
        $tickets->post('/create', [TicketController::class, 'create']);

        $tickets->put('/update', [TicketController::class, 'update']);

        $tickets->delete('/delete', [TicketController::class, 'delete']);

    })->add(AuthMiddleware::class);

    $app->group('devices', function(RouteCollectorProxy $devices) {

        $devices->get('', [DeviceController::class, 'index']);
        $devices->get('/new', [DeviceController::class, 'new']);
        $devices->get('/{id}', [DeviceController::class, 'show']);
        $devices->get('/{id}/edit', [DeviceController::class, 'edit']);
        
        $devices->post('/create', [DeviceController::class, 'create']);

        $devices->put('/update', [DeviceController::class, 'update']);

        $devices->delete('/delete', [DeviceController::class, 'delete']);

    })->add(AuthMiddleware::class);
};