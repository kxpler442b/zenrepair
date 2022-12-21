<?php

/**
 * bootstrap.php
 * 
 * parse settings, insantiate slim container and execute the application
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

require 'vendor/autoload.php';

$app_path = __DIR__ . '/app';
$config_path = __DIR__ . '/app/config';

$settings = require $app_path . '/config/zenrepair.config.php';

$container = new \Slim\Container($settings);

require $app_path . '/dependencies.php';

$app = new \Slim\App($container);

require $app_path . '/router.php';

$app->run();