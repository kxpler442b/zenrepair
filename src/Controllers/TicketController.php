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

use App\Services\TicketService;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TicketController
{
    private readonly ContainerInterface $container;
    private readonly TicketService $ticketService;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->ticketService = $container->get(TicketService::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'hypr_url' => HYPR_URL,
            'title' => 'Tickets - RSMS',
            'controller' => [
                'base_url' => '/tickets',
                'name' => 'ticket',
                'Name' => 'Ticket'
            ]
        ];

        return $this->twig->render($response, '/table_view.twig', $twig_data);
    }

    public function createView(RequestInterface $request, ResponseInterface $response)
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'hypr_url' => HYPR_URL,
            'title' => 'Tickets - RSMS',
            'controller' => [
                'base_url' => '/tickets',
                'name' => 'ticket',
                'Name' => 'Ticket'
            ]
        ];

        return $this->twig->render($response, '/create_view.twig', $twig_data);
    }

    public function getCreator(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/tickets',
                'Name' => 'Ticket'
            ],
        ];

        return $this->twig->render($response, '/frags/creator/ticket.twig', $twig_data);
    }

    public function getTable(RequestInterface $request, ResponseInterface $response)
    {
        $rows = [];
        $tickets = $this->ticketService->getAll();

        foreach($tickets as &$ticket)
        {
            $rows[$ticket->getId()->toString()] = array($ticket->getSubject(), [$ticket->getStatus(), 'null', 'null', 'null', $ticket->getCreated()->format('d-m-Y'), $ticket->getUpdated()->format('d-m-Y H:i:s')]);
        }

        $twig_data = [
            'controller' => [
                'base_url' => '/customers',
                'name' => 'ticket',
                'Name' => 'Customer'
            ],
            'table' => [
                'headers' => ['Subject', 'Status', 'Created By', 'Device', 'Customer', 'Date Created', 'Last Updated'],
                'rows' => $rows
            ]
        ];

        return $this->twig->render($response, '/frags/read/table.html', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}