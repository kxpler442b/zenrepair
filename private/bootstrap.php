<?php

/**
 * 
 */

include __DIR__ . '/../vendor/autoload.php';

$app_path = __DIR__ . '/app';

include __DIR__ . '/../config/autoload.php';

$container = new \Slim\Container(SLIM_SETTINGS);

require 'dependencies.php';

$slim = new \Slim\App($container);

require 'routes.php';

session_start();

$slim->run();