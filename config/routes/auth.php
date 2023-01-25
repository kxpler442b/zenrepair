<?php

/**
 * Authentication route strategies.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

$app->get('/', \App\Controllers\HomeController::class . ':homeView')->setname('home_view');