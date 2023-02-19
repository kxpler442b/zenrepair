<?php

/**
 * Example controller layout.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 17/02/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class Controller
{
    private readonly ContainerInterface $container;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'title' => 'Example'
        ];

        return $this->twig->render($response, '/example_view.twig', $twig_data);
    }

    public function create(RequestInterface $request, ResponseInterface $response)
    {

    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}