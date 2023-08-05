<?php

declare(strict_types = 1);

use Slim\App;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Slim\Routing\RouteCollectorProxy;
use App\Http\Action\Web\ViewDashboard;
use App\Http\Middleware\AuthMiddleware;

return function(App $app)
{
    $app->options('/{routes:.*}', function(Request $request, Response $response) {
        /**
         * CORS Pre-Flight OPTIONS Request Handler
         */

        return $response;
    });

    $app->group('/', function(RouteCollectorProxy $auth) {
        
    });

    $app->group('/web', function(RouteCollectorProxy $web) {
        $web->get('/dashboard', ViewDashboard::class);
    });

    $app->group('/api', function(RouteCollectorProxy $api) {
        
    })->add(AuthMiddleware::class);
};