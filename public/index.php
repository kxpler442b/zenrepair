<?php

/**
 * Prepare and execute the application.
 * 
 * @author Benjamin Moss <ben@yubit.social>
 * 
 * Date: 26/05/23
 */

declare(strict_types = 1);

use Dotenv\Dotenv;
use Slim\ResponseEmitter;

require __DIR__ . '/../vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__, '../app.env');
$env->load();

define('BASE_URL', $_ENV['APP_BASE_URL']);

$app = require __DIR__ . '/../app/bootstrap.php';

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);