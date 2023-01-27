<?php

/**
 * Base controller class.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Views\Twig;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
    protected $container;
    protected $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    public function render(ResponseInterface $response, string $template, array $twig_data)
    {
        return $this->twig->render($response, $template, $twig_data);
    }
}