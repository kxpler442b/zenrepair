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
use App\Controller\DashboardController;
use App\Controller\SecurityController;
use App\Controller\UserController;
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

        $view->get('/users', [ViewController::class, 'viewUsers']);
        $view->get('/user/{id}', [ViewController::class, 'viewUser']);

        $view->get('/creator/{context}', [ViewController::class, 'viewCreator']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/workshop', function(RouteCollectorProxy $workshop) {
        $workshop->get('', [ViewController::class, 'viewWorkshop']);

        $workshop->get('/tickets', [ViewController::class, 'viewTickets']);
        $workshop->get('/ticket/{id}', [ViewController::class, 'viewTicket']);

        $workshop->get('/customers', [ViewController::class, 'viewCustomers']);
        $workshop->get('/customer/{id}', [ViewController::class, 'viewCustomer']);

        $workshop->get('/devices', [ViewController::class, 'viewDevices']);
        $workshop->get('/device/{id}', [ViewController::class, 'viewDevice']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/dashboard', function(RouteCollectorProxy $dashboard) {
        $dashboard->get('/get/stats', [DashboardController::class, 'getStats']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/users', function (RouteCollectorProxy $users) {
        $users->get('/get', [UserController::class, 'getUserRecords']);
        $users->get('/get/{id}', [UserController::class, 'getUserRecord']);

        $users->put('/create', [AccountController::class]);
        $users->put('/update', [AccountController::class]);
        $users->put('/delete', [AccountController::class]);
    })->add(LocalAuthMiddleware::class);

    $app->group('/customers', function (RouteCollectorProxy $customers) {
        $customers->get('/get/creator', [CustomerController::class, 'getCreator']);
        $customers->get('/get/creator/{step}', [CustomerController::class, 'getCreator']);

        $customers->get('/get', [CustomerController::class, 'getRecords']);
        $customers->get('/get/{id}', [CustomerController::class, 'getRecord']);

        $customers->post('/create', [CustomerController::class, 'create']);
        $customers->put('/update', [CustomerController::class]);
        $customers->get('/delete/{id}', [CustomerController::class, 'delete']);
    })->add(LocalAuthMiddleware::class);

    $app->group('/tickets', function (RouteCollectorProxy $tickets) {
        $tickets->get('/get', [TicketController::class, 'getRecords']);
        $tickets->get('/get/{id}', [TicketController::class, 'getRecord']);

        $tickets->put('/create', [TicketController::class]);
        $tickets->put('/update', [TicketController::class]);
        $tickets->put('/delete', [TicketController::class]);
    })->add(LocalAuthMiddleware::class);

    $app->group('/devices', function (RouteCollectorProxy $devices) {
        $devices->get('/get', [DeviceController::class, 'getRecords']);
        $devices->get('/get/{id}', [DeviceController::class, 'getRecord']);

        $devices->put('/create', [DeviceController::class]);
        $devices->put('/update', [DeviceController::class]);
        $devices->put('/delete', [DeviceController::class]);
    })->add(LocalAuthMiddleware::class);
};