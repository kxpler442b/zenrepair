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
    protected $database;

    protected $method;
    protected $params;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get('twig');
        $this->database = $container->get('database');

        $this->method = 'GET';
        $this->params = [];
    }

    public function __destruct() {}

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }
}