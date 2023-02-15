<?php

/**
 * Tickets Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\TicketService;
use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TicketController
{
    private readonly ContainerInterface $container;
    private readonly Twig $twig;
    private readonly TicketService $ticketService;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->twig = $container->get(Twig::class);
        $this->ticketService = $container->get(TicketService::class);
    }

    public function tableView(Request $request, Response $response) : Response
    {
        $twig_data = [
            'css_path' => CSS_URL,
            'assets_path' => ASSETS_URL,
            'title' => 'Tickets - RSMS',
            'context' => [
                'name' => 'ticket',
                'Name' => 'Ticket'
            ],
            'table' => [
                'headers' => ['Subject', 'Status', 'Technician', 'Customer', 'Device', 'Date Created', 'Last Updated'],
                'rows' => [
                    '63e52f0bb89e9' => ['Screen Replacement', ['In Progress', 'Benjamin Moss', 'Eugene Krabs', 'iPhone 7', '01-01-2023 12:00', '01-01-2023 12:00']],
                    '63e52f0bb89a1' => ['Battery Replacement', ['Not Started', 'Benjamin Moss', 'Kermit Frog', 'iPhone 6s', '01-01-2023 12:00', '01-01-2023 12:00']]
                ]
            ]
        ];

        return $this->twig->render($response, '/table_view.twig', $twig_data);
    }

    public function createTicketView(Request $request, Response $response) : Response
    {
        $twig_data = [
            'css_path' => CSS_URL,
            'assets_path' => ASSETS_URL,
            'title' => 'Tickets - RSMS',
            'category' => [
                'url' => 'tickets',
                'singularName' => 'Ticket'
            ]
        ];

        return $this->twig->render($response, '/create_view.twig', $twig_data);
    }
}