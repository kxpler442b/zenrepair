<?php

/**
 * AppController.php
 * 
 * Main application endpoints controller.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 07/12/22
 * 
 * @author B Moss
 */

namespace App\Controllers;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

use Psr\Container\ContainerInterface as ContainerInterface;

use App\Models\TicketModel as TicketModel;

class AppController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('view');
    }

    public function __destruct() {}

    /**
     * Endpoint /dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function dashboard(Request $request, Response $response)
    {
        $ticketModel = new TicketModel;
        $tickets = $ticketModel->queryGetTicket('zynepjjhwiaeqvn');

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Dashboard',
            'tickets' => $tickets
        ];

        return $this->view->render($response, '/testing/test_view.twig', $twig_data);
    }

    /**
     * Endpoint /customers
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function customers(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Customers - ZenRepair'
        ];

        return $this->view->render($response, '/app/customers_view.twig', $twig_data);
    }

    /**
     * Endpoint /tickets
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function tickets(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Tickets - ZenRepair'
        ];

        return $this->view->render($response, '/app/tickets_view.twig', $twig_data);
    }
}