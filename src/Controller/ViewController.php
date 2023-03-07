<?php

/**
 * Web app interface controller.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 01/03/2023
 */

declare(strict_types = 1);

namespace App\Controller;

use App\Service\CustomerService;
use App\Service\DeviceService;
use App\Service\TicketService;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class ViewController
{
    private readonly CustomerService $customerService;
    private readonly DeviceService $deviceService;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->customerService = $c->get(CustomerService::class);
        $this->deviceService = $c->get(DeviceService::class);
        $this->twig = $c->get(Twig::class);

        $this->addTwigGlobals();
    }

    public function viewCreator(Request $request, Response $response, array $args): Response
    {
        if($args['context'] == 'customer')
        {
            $context = [
                'name' => 'customer',
                'Name' => 'Customer'
            ];
        }

        $data = [
            'page' => [
                'title' => 'Create '. $context['Name'],
                'context' => $context
            ]
        ];

        return $this->twig->render($response, '/create/layout.html.twig', $data);
    }

    public function viewDashboard(Request $request, Response $response): Response
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

        return $this->twig->render($response, '/dashboard/layout.html.twig', $data);
    }

    public function viewTickets(Request $request, Response $response): Response
    {
        $data = [
            'page' => [
                'title' => 'Tickets - RSMS',
                'context' => [
                    'name' => 'ticket',
                    'Name' => 'Ticket'
                ]
            ]
        ];

        return $this->twig->render($response, '/read/records.html.twig', $data);
    }

    public function viewCustomers(Request $request, Response $response): Response
    {
        $data = [
            'page' => [
                'title' => 'Customers - RSMS',
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ]
        ];

        return $this->twig->render($response, '/read/records.html.twig', $data);
    }

    public function viewCustomer(Request $request, Response $response, array $args): Response
    {
        $customerId = $args['id'];
        $customer = $this->customerService->getByUuid($customerId);

        $display_name = $customer->getFirstName() . ' ' . $customer->getLastName();

        $data = [
            'page' => [
                'title' => $display_name . ' - RSMS',
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ],
                'record' => [
                    'id' => $customerId,
                    'display_name' => $display_name
                ]
            ]
        ];

        return $this->twig->render($response, '/read/record.html.twig', $data);
    }

    public function viewDevices(Request $request, Response $response): Response
    {
        $data = [
            'page' => [
                'title' => 'Devices - RSMS',
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ]
            ]
        ];

        return $this->twig->render($response, '/read/records.html.twig', $data);
    }

    public function viewDevice(Request $request, Response $response, array $args): Response
    {
        $deviceId = $args['id'];
        $device = $this->deviceService->getByUuid($deviceId);

        $display_name = $device->getManufacturer().' '.$device->getModel();

        $data = [
            'page' => [
                'title' => $display_name . ' - RSMS',
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ],
                'record' => [
                    'id' => $deviceId,
                    'display_name' => $display_name
                ]
            ]
        ];

        return $this->twig->render($response, '/read/record.html.twig', $data);
    }

    private function addTwigGlobals()
    {
        $this->twig->getEnvironment()->addGlobal('globals', [
            'base_url' => BASE_URL,
            'favicon_url' => FAVICON_URL,
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL
        ]);
    }
}