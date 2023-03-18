<?php

/**
 * Dashboard controller.
 * 
 * @author Benjamin Moss <p2595849@dmu.ac.uk>
 * 
 * Date: 10/03/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Interface\SessionInterface;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;

class DashboardController
{
    private readonly ContainerInterface $c;
    private readonly LocalAccountService $users;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->users = $c->get(LocalAccountService::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function getStats(Request $request, Response $response): Response
    {
        $data = [
            'page' => [
                'title' => 'Dashboard - RSMS',
                'context' => [
                    'name' => 'dashboard',
                    'Name' => 'Dashboard'
                ]
            ]
        ];

        return $this->twig->render($response, '/dashboard/stats.html', $data);
    }
}