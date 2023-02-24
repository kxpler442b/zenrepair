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
use App\Middleware\LocalAuthMiddleware;

return function (App $app)
{
    $app->group('/', function (RouteCollectorProxy $auth) {
        $auth->get('', [AuthController::class, 'index']);
        $auth->post('', [AuthController::class, 'authUser']);
        $auth->get('logout', [AuthController::class, 'logout']);

        $auth->get('debug', [AuthController::class, 'debug0']);
    });

    $app->group('/dashboard', function (RouteCollectorProxy $dashboard) {
        $dashboard->get('', [DashboardController::class, 'index']);
    });

    $app->group('/tickets', function (RouteCollectorProxy $tickets) {
        $tickets->get('', [TicketController::class, 'index']);

        $tickets->get('/get/creator', [TicketController::class, 'getCreator']);
        $tickets->post('/create/{id}', [TicketController::class, 'createTicket']);

        $tickets->get('/view/{id}', [TicketController::class, 'ticketView']);
        $tickets->get('/get/table', [TicketController::class, 'getTable']);

        $tickets->post('/delete/{id}', [TicketController::class, 'deleteTicket']);
    });

    $app->group('/customers', function (RouteCollectorProxy $customers) {
        $customers->get('', [CustomerController::class, 'index']);

        $customers->get('/get/creator', [CustomerController::class, 'getCreator']);
        $customers->post('/create', [CustomerController::class, 'create']);

        $customers->get('/view/{id}', [CustomerController::class, 'viewCustomer']);
        $customers->get('/get/table', [CustomerController::class, 'getTable']);
        $customers->get('/get/record/{id}', [CustomerController::class, 'getRecord']);

        $customers->post('/delete/{id}', [CustomerController::class, 'deleteTicket']);
    });

    $app->group('/devices', function (RouteCollectorProxy $devices) {
        $devices->get('', [DeviceController::class, 'index']);

        $devices->get('/create', [DeviceController::class, 'createView']);
        $devices->post('/create', [DeviceController::class, 'createDevice']);
        
        $devices->get('/view/{id}', [DeviceController::class, 'viewRecord']);
        $devices->get('/get/table', [DeviceController::class, 'getTable']);
        
        $devices->post('/delete/{id}', [DeviceController::class, 'deleteDevice']);
    });
};