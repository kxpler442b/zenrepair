<?php

declare(strict_types = 1);

namespace App\Service;

use Psr\Container\ContainerInterface;

final class UserService extends Service
{
    public function __construct(ContainerInterface $c)
    {
        parent::__construct($c);
    }
}