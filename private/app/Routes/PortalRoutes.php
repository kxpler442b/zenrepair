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

$slim->get('/portal', \App\Controllers\PortalController::class . ':login_view')->setname('portal_login_view');
$slim->post('/portal/verify', \App\Controllers\PortalController::class . ':verify')->setname('portal_verify');

$slim->get('/portal/view', \App\Controllers\PortalController::class . ':portal_view')->setname('portal_view');

$slim->get('/portal/logout', \App\Controllers\PortalController::class . ':logout')->setname('portal_logout');