<?php

declare(strict_types = 1);

use Dotenv\Dotenv;
use DI\ContainerBuilder;
use App\Support\Settings\Settings;

require_once __DIR__ . '/../vendor/autoload.php';

if($_ENV['DOCKER'] == 0) {
    Dotenv::createImmutable([__DIR__ . '/../'], ['app.env'])->load();
}

$container = (new ContainerBuilder())
    ->addDefinitions(__DIR__ . '/settings.php')
    ->addDefinitions(__DIR__ . '/dependencies.php')
    ->build();

$settings = $container->get(Settings::class);

return $container;