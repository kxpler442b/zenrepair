<?php

declare(strict_types = 1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

abstract class Service
{
    protected LoggerInterface $logger;

    public function __construct(ContainerInterface $c)
    {
        $this->logger = $c->get(LoggerInterface::class);
    }
}