<?php

/**
 * Base controller class.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __destruct() {}
}