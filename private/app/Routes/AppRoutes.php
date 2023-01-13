<?php

/**
 * Routes HTTP requests related to the user application.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

$slim->get('/dashboard', \App\Controllers\DashboardController::class . ':dashboard')->setname('dashboard');

$slim->get('/customers', \App\Controllers\CustomerController::class . ':customers_data')->setname('customers_data');
$slim->get('/customers/create', \App\Controllers\CustomerController::class . ':customers_create')->setname('customers_create');
$slim->post('/customers/create', \App\Controllers\CustomerController::class . ':customers_commit')->setname('customers_commit');
$slim->get('/customers/{id}', \App\Controllers\CustomerController::class . ':customer_view')->setname('customers_view');

$slim->get('/tickets', \App\Controllers\TicketController::class . ':tickets_view')->setname('tickets_view');

$slim->get('/devices', \App\Controllers\DeviceController::class . ':devices')->setname('devices');