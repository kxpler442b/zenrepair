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
    public function tickets_create(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $technicians = $this->database->users->getAllUsers('id, first_name, last_name');
        $customers = $this->database->customers->getAllCustomers('id, first_name, last_name');
        $devices = $this->database->devices->getAllDevices('id, manufacturer, model');

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets',
            'technicians' => $technicians,
            'customers' => $customers,
            'devices' => $devices
        ];

        return $this->twig->render($response, '/app/tickets/ticket_create.twig', $twig_data);
    }

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

        return $this->twig->render($response, '/app/tickets/tickets_view.twig', $twig_data);
    }

    public function ticket_view(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $ticket = $this->database->tickets->getTicket($args['id']);

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets',
            'ticket' => $ticket[0]
        ];

        return $this->twig->render($response, '/app/tickets/ticket_view.twig', $twig_data);
    }

    public function ticket_update(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $ticket = $this->database->tickets->getTicket($args['id']);

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets',
            'ticket' => $ticket[0]
        ];

        return $this->twig->render($response, '/app/tickets/ticket_view.twig', $twig_data);
    }

    public function ticket_delete(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $ticket = $this->database->tickets->getTicket($args['id']);

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets',
            'ticket' => $ticket[0]
        ];

        return $this->twig->render($response, '/app/tickets/ticket_view.twig', $twig_data);
    }
}