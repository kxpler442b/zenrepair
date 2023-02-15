<?php

/**
 * Registers routes onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Controllers\AuthController;
use App\Controllers\DeviceController;
use App\Controllers\TicketController;
use Slim\Routing\RouteCollectorProxy;

use App\Controllers\CustomerController;
use App\Controllers\DashboardController;

return function (App $app)
{
    $app->group('', function (RouteCollectorProxy $auth) {
        $auth->get('/', [AuthController::class, 'index']);
        $auth->post('/', [AuthController::class, 'authUser']);
        $auth->get('/logout', [AuthController::class, 'logout']);
    });

    $app->get('/dashboard', [DashboardController::class, 'dashboardView']);

    $app->group('/tickets', function (RouteCollectorProxy $tickets) {
        $tickets->get('', [TicketController::class, 'tableView']);
        $tickets->get('/create', [TicketController::class, 'createView']);
        $tickets->post('/create/{id}', [TicketController::class, 'createTicket']);
        $tickets->get('/view/{id}', [TicketController::class, 'ticketView']);
        $tickets->post('/delete/{id}', [TicketController::class, 'deleteTicket']);
    });

    $app->get('/customers', [CustomerController::class, 'customersView']);

    $app->get('/devices', [DeviceController::class, 'devicesView']);
};