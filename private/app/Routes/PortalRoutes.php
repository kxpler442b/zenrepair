<?php

/**
 * Handles HTTP requests to the customer portal.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

$slim->get('/portal', \App\Controllers\PortalController::class . ':login_view')->setname('portal_view');
$slim->post('/portal', \App\Controllers\PortalController::class . ':login_handler')->setname('portal_auth');

$slim->get('/portal/logout', \App\Controllers\PortalController::class . ':logout')->setname('portal_logout');