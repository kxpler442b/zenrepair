<?php

/**
 * Main application route strategies.
 * 
 * Author: B Moss
 * Date: 23/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

use \App\Controllers\HomeController;

$app->get('/home', HomeController::class, ':homeView');