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

$slim->get('/login', \App\Controllers\AuthController::class . ':login')->setname('login_get');
$slim->post('/login', \App\Controllers\AuthController::class . ':login')->setname('login_post');

$slim->get('/logout', \App\Controllers\AuthController::class . ':logout')->setname('logout');