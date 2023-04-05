<?php

/**
 * Authentication controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class DashboardController
{
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->twig = $c->get(Twig::class);
    }

    /**
     * Returns the dashboard view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Dashboard',
                'context' => [
                    'name' => 'dashboard',
                    'Name' => 'Dashboard'
                ]
            ]
        ];

        return $this->twig->render($response, '/app/dashboard_view.html.twig', $twig_data);
    }
}