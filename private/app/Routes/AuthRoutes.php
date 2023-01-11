<?php

/**
 * Routes HTTP requests related to user authentication.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

$slim->get('/', \App\Controllers\AuthController::class . ':index')->setname('index');

$slim->get('/login', \App\Controllers\AuthController::class . ':oauth_redirect')->setname('oauth_redirect');
$slim->get('/login/callback', \App\Controllers\AuthController::class . ':oauth_callback')->setname('oauth_callback');

$slim->get('/logout', \App\Controllers\AuthController::class . ':logout')->setname('logout');