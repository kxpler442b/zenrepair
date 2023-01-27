<?php

/**
 * Registers routes onto the Slim application instance.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\TicketController;

use Slim\App;

return function (App $app)
{
    $app->get('/dashboard', [DashboardController::class, 'dashboardView']);

    $app->get('/tickets', [TicketController::class, 'ticketView']);
};