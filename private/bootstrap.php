<?php

/**
 * 
 */

include '../vendor/autoload.php';

$app_path = __DIR__ . '/app';

include '../config/autoload.php';

$container = new \Slim\Container(SLIM_SETTINGS);

require 'dependencies.php';

$slim = new \Slim\App($container);

require 'routes.php';

session_start();

$slim->run();