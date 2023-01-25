<?php

/**
 * Configure the application.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

require __DIR__ . '/vendor/autoload.php';

require __DIR__ . '/config/constants.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = require CONFIG_PATH . '/container.php';

return new \Slim\App($container);