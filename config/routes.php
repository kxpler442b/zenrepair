<?php

/**
 * Registers routes onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Controller\ViewController;
use App\Controller\DeviceController;
use App\Controller\TicketController;
use Slim\Routing\RouteCollectorProxy;
use App\Controller\CustomerController;
use App\Controller\SecurityController;
use App\Middleware\LocalAuthMiddleware;

return function (App $app)
{
    $app->group('/', function (RouteCollectorProxy $auth) {
        $auth->get('', [SecurityController::class, 'index']);
        $auth->get('logout', [SecurityController::class, 'logout']);

        $auth->post('', [SecurityController::class, 'authUser']);
    });

    $app->group('/view', function (RouteCollectorProxy $view) {
        $view->get('/dashboard', [ViewController::class, 'viewDashboard']);
        $view->get('/tickets', [ViewController::class, 'viewTickets']);
        $view->get('/customers', [ViewController::class, 'viewCustomers']);
        $view->get('/customer/{id}', [ViewController::class, 'viewCustomer']);
        $view->get('/devices', [ViewController::class, 'viewDevices']);
        $view->get('/device/{id}', [ViewController::class, 'viewDevice']);

        $view->get('/creator/{context}', [ViewController::class, 'viewCreator']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/users', function (RouteCollectorProxy $users) {
        $users->get('/get', [AccountController::class]);
        $users->get('/get/{id}', [AccountController::class]);

        $users->put('/create', [AccountController::class]);
        $users->put('/update', [AccountController::class]);
        $users->put('/delete', [AccountController::class]);
    })->add(LocalAuthMiddleware::class);

    $app->group('/customers', function (RouteCollectorProxy $customers) {
        $customers->get('/get/creator', [CustomerController::class, 'getCreator']);
        $customers->get('/get', [CustomerController::class, 'getList']);
        $customers->get('/get/{id}', [CustomerController::class, 'getRecord']);

        $customers->post('/create', [CustomerController::class, 'create']);
        $customers->put('/update', [CustomerController::class]);
        $customers->get('/delete/{id}', [CustomerController::class, 'delete']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/tickets', function (RouteCollectorProxy $tickets) {
        $tickets->get('/get', [TicketController::class, 'getList']);
        $tickets->get('/get/{id}', [TicketController::class]);

        $tickets->put('/create', [TicketController::class]);
        $tickets->put('/update', [TicketController::class]);
        $tickets->put('/delete', [TicketController::class]);
    })->add(LocalAuthMiddleware::class);

    $app->group('/devices', function (RouteCollectorProxy $devices) {
        $devices->get('/get', [DeviceController::class, 'getList']);
        $devices->get('/get/{id}', [DeviceController::class, 'getRecord']);

        $devices->put('/create', [DeviceController::class]);
        $devices->put('/update', [DeviceController::class]);
        $devices->put('/delete', [DeviceController::class]);
    })->add(LocalAuthMiddleware::class);
};