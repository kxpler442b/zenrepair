<?php

/**
 * Set up and execute the application.
 * 
 * Author: B Moss
 * Email: <p2595849@my.dmu.ac.uk>
 * Date: 20/01/23
 * 
 * @author B Moss
 */

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/constants.config.php';

require_once CONFIG_PATH . '/app.config.php';

$container = new \Slim\Container($app_config);

require_once __DIR__ . '/dependencies.php';

$app = new \Slim\App($app_config);

require_once __DIR__ . '/routes.php';

session_start();

$app->run();