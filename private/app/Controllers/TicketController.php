<?php

/**
 * Handles the Ticket views.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

namespace App\Controllers;

use \Slim\Http\Request;
use \Slim\Http\Response;

class TicketController extends BaseController
{
    public function tickets_view(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $tickets = $this->database->tickets->getAllTickets();

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets',
            'tickets' => $tickets
        ];

        var_dump($tickets);

        return $this->twig->render($response, '/app/tickets/tickets_view.twig', $twig_data);
    }
}