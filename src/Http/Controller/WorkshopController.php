<?php

/**
 * Users controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use App\Interface\SessionInterface;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class UserController
{
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    public function __construct(ContainerInterface $c)
    {
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
    }

    public function index(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Workshop - RSMS',
                'context' => [
                    'name' => 'workshop',
                    'Name' => 'Workshop'
                ]
            ]
        ];

        return $this->twig->render($response, '/app/workshop_view.html.twig', $twig_data);
    }
}