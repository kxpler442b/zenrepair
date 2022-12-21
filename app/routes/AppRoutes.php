<?php

/**
 * AppRoutes.php
 * 
 * To Do: Describe this PHP file.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 07/12/22
 * 
 * @author B Moss
 */

$app->get('/dashboard', \App\Controllers\AppController::class . ':dashboard')->setname('dashboard');
$app->get('/customers', \App\Controllers\AppController::class . ':customers')->setname('customers');
$app->get('/tickets', \App\Controllers\AppController::class . ':tickets')->setname('tickets');