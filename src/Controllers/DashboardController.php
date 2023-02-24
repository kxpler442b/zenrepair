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

use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DashboardController
{
    private readonly SessionInterface $session;
    private readonly Twig $twig;
    private readonly AuthInterface $auth;

    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get(AuthInterface::class);

        $this->twig = $container->get(Twig::class);
        $this->session = $container->get(SessionInterface::class);
    }

    public function __destruct() {}

    /**
     * User dashboard view.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * 
     * @return ResponseInterface
     */
    public function index(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'title' => 'Dashboard - RSMS',
            'controller' => [
                'base_url' => '/dashboard',
                'name' => 'dashboard',
                'Name' => 'Dashboard'
            ]
        ];

        return $this->twig->render($response, '/dashboard_view.twig', $twig_data);
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