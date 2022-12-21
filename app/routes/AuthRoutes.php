<?php

/**
 * AuthRoutes.php
 * 
 * To Do: Describe this PHP file.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 07/12/22
 * 
 * @author B Moss
 */

$app->get('/', \App\Controllers\AuthController::class . ':index')->setname('index');
$app->get('/login', \App\Controllers\AuthController::class . ':login')->setname('login');
$app->get('/logout', \App\Controllers\AuthController::class . ':logout')->setname('logout');