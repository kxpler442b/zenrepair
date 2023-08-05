<?php

declare(strict_types = 1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use App\Http\Handler\HttpErrorHandler;
use App\Support\Settings\SettingsInterface;
use Slim\Factory\ServerRequestCreatorFactory;

$cb = new ContainerBuilder();

$settings = require __DIR__ . '/settings.php';
$settings($cb);

$dependencies = require __DIR__ . '/dependencies.php';
$dependencies($cb);

$c = $cb->build();

AppFactory::setContainer($c);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

$middleware = require __DIR__ . '/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/routes.php';
$routes($app);

$settings = $c->get(SettingsInterface::class);

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(
    (bool) $settings->get('displayErrorDetails'), 
    (bool) $settings->get('logError'), 
    (bool) $settings->get('logErrorDetails')
);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

return $app;