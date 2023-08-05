<?php

declare(strict_types = 1);

namespace App\Http\Action\Api;

use App\Http\Action\Action;
use Psr\Log\LoggerInterface;
use App\M2M\Interface\M2MInterface;
use Psr\Container\ContainerInterface;

abstract class ApiAction extends Action
{
    protected M2MInterface $m2m;
    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $c, LoggerInterface $logger)
    {
        $this->m2m = $c->get(M2MInterface::class);
        $this->logger = $c->get(LoggerInterface::class);
        
        parent::__construct($c, $logger);
    }
}