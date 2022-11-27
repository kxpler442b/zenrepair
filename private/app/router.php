<?php

/**
 * router.php
 * 
 * passes requests off to their respective controllers
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

// Authentication Endpoints
$app->get('/', \App\Controllers\AuthController::class . ':index');
$app->get('/login', \App\Controllers\AuthController::class . ':login');

$app->get('/dashboard', \App\Controllers\DashController::class . ':dashboard');

// Customer Portal Endpoints
$app->get('/portal', \App\Controllers\PortalController::class . ':portal');