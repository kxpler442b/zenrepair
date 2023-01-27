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
    public function ticketView(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_URI,
            'title' => 'Tickets - RSMS',
            'category' => [
                'name' => 'Tickets'
            ]
        ];

        return $this->render($response, '/category_view.twig', $twig_data);
    }
}