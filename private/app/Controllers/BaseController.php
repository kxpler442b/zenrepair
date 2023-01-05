<?php

/**
 * 
 */

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class BaseController
{
    protected $container;
    protected $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get('twig');
    }

    public function __destruct() {}

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }
}