<?php

/**
 * 
 */

declare (strict_types = 1);

namespace App\Models;

abstract class BaseModel
{
    protected $container;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }
}