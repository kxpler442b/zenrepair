<?php

/**
 * Customer portal controller.
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
use App\Service\DeviceService;
use App\Service\TicketService;
use App\Service\CustomerService;
use Psr\Container\ContainerInterface;

class PortalController
{
    private readonly TicketService $tickets;
    private readonly CustomerService $customers;
    private readonly DeviceService $devices;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->tickets = $c->get(TicketService::class);
        $this->customers = $c->get(CustomerService::class);
        $this->devices = $c->get(DeviceService::class);
        $this->twig = $c->get(Twig::class);
    }

    public function home(Request $request, Response $response): Response
    {
        $twig_data = [
            'customer' => [
                'first_name' => 'Test',
                'last_name' => 'Testicle'
            ]
        ];

        return $this->twig->render($response, '/portal/portal.html.twig', $twig_data);
    }
}