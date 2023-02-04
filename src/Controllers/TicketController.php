<?php

/**
 * Tickets Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TicketController extends Controller
{
    public function ticketsView(Request $request, Response $response) : Response
    {
        $twig_data = [
            'css_path' => CSS_URL,
            'assets_path' => ASSETS_URL,
            'title' => 'Tickets - RSMS',
            'category' => [
                'url' => 'tickets',
                'singularName' => 'Ticket',
                'table' => [
                    'headers' => ['Subject', 'Status', 'Technician', 'Customer', 'Device', 'Date Created', 'Last Updated'],
                    'rows' => [
                        0 => ['Screen Replacement', 'In Progress', 'Benjamin Moss', 'Eugene Krabs', 'iPhone 7', '01-01-2023 12:00', '01-01-2023 12:00'],
                        1 => ['Battery Replacement', 'Not Started', 'Benjamin Moss', 'Kermit Frog', 'iPhone 6s', '01-01-2023 12:00', '01-01-2023 12:00']
                    ]
                ]
            ]
        ];

        return $this->render($response, '/category_view.twig', $twig_data);
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

        return $this->render($response, '/create_view.twig', $twig_data);
    }
}