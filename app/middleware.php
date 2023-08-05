<?php

declare(strict_types = 1);

use Slim\App;
use Odan\Session\Middleware\SessionStartMiddleware;

return function(App $app)
{
    $app->add(SessionStartMiddleware::class);
};