<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Http\Action\Action;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;
use Auth0\SDK\Contract\Auth0Interface;

abstract class AuthAction extends Action
{
    protected Auth0Interface $auth0;

    public function __construct(ContainerInterface $c, LoggerInterface $logger)
    {
        $this->auth0 = $c->get(Auth0Interface::class);
        
        parent::__construct($c, $logger);
    }
}