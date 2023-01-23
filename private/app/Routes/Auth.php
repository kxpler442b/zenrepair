<?php

/**
 * Authentication related route strategies.
 * 
 * Author: B Moss
 * Date: 20/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

$app->get('/', \App\Controllers\AuthController::class, ':indexRedirect');

$app->get('/login', \App\Controllers\AuthController::class, ':oktaRedirect');
$app->get('/login/callback', \App\Controllers\AuthController::class, ':oktaCallback');

$app->get('/logout', \App\Controllers\AuthController::class, ':logout');