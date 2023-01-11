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
$slim->get('/customers', \App\Controllers\CustomerController::class . ':customers')->setname('customers');
$slim->get('/tickets', \App\Controllers\TicketController::class . ':tickets')->setname('tickets');
$slim->get('/devices', \App\Controllers\DeviceController::class . ':devices')->setname('devices');