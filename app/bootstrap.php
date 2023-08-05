<?php

declare(strict_types = 1);

use Dotenv\Dotenv;
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';

$env = Dotenv::createImmutable(__DIR__, '../app.env');
$env->load();

define('BASE_URL', $_ENV['APP_BASE_URL']);

$cb = new ContainerBuilder();

$settings = require __DIR__ . '/settings.php';
$settings($cb);

$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($cb);

return $cb->build();