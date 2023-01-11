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
    protected $okta;
    protected $validator;
    protected $logger;

    protected $method;
    protected $params;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get('twig');
        $this->logger = $container->get('logger');
        $this->database = $container->get('database');
        $this->okta = $container->get('okta');
        $this->validator = $container->get('validator');

        $this->method = 'GET';
        $this->params = [];
    }

    public function __destruct() {}

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }
}