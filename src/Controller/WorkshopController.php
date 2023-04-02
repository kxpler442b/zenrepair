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

use App\Interface\SessionInterface;
use App\Service\CustomerService;
use App\Service\DeviceService;
use App\Service\TicketService;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;
use Valitron\Validator;

class WorkshopController
{
    private readonly CustomerService $customerService;
    private readonly DeviceService $deviceService;
    private readonly TicketService $ticketService;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->customerService = $c->get(CustomerService::class);
        $this->deviceService = $c->get(DeviceService::class);
        $this->ticketService = $c->get(TicketService::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function viewCreate(Request $request, Response $response, array $args): Response
    {
        $context = $args['context'];

        $whitelist = array('customer', 'device');

        $rules = [
            'required' => ['context'],
            'in' => $whitelist
        ];

        $v = new Validator([
            'context' => $context
        ]);

        $v->rules($rules);

        if($v->validate()) {

            $data = [
                'zone' => 'workshop',
                'page' => [
                    'context' => [
                        'name' => $context,
                        'Name' => ucwords($context)
                    ]
                ]
            ];

            return $this->twig->render($response, '/workshop/create_view.html.twig', $data);
        }
        else {
            return $response->withStatus(404);
        }
    }

    /**
     * Returns a predefined notice block if it is found in the whitelist.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function getNotice(Request $request, Response $response, array $args): Response
    {
        $page_name = $args['notice'];

        $whitelist = array('gdpr_accuracy');

        $rules = [
            'required' => ['page_name'],
            'in' => $whitelist
        ];

        $v = new Validator([
            'page_name' => $page_name
        ]);

        $v->rules($rules);

        if($v->validate()) {
            return $this->twig->render($response, '/workshop/notices/'.$page_name.'.html.twig');
        }
        else {
            return $response->withStatus(500);
        }
    }

    public function viewSettings(Request $request, Response $response): Response
    {
        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => 'Settings - RSMS',
                'context' => [
                    'name' => 'settings',
                    'Name' => 'Settings'
                ]
            ]
        ];

        return $this->twig->render($response, '/user/settings.html.twig', $data);
    }

    public function viewDashboard(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => 'Dashboard - RSMS',
                'context' => [
                    'name' => 'dashboard',
                    'Name' => 'Dashboard'
                ]
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/dashboard/dashboard.html.twig', $data);
    }

    public function viewTickets(Request $request, Response $response): Response
    {
        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => 'Tickets - RSMS',
                'context' => [
                    'name' => 'ticket',
                    'Name' => 'Ticket'
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewTicket(Request $request, Response $response, array $args): Response
    {
        $ticketId = $args['id'];
        $ticket = $this->ticketService->getByUuid($ticketId);

        $device = $ticket->getDevice();
        $deviceName = $device->getManufacturer().' '.$device->getModel();

        $displayName = $ticket->getSubject().' For '.$deviceName;

        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => $displayName . ' - RSMS',
                'context' => [
                    'name' => 'ticket',
                    'Name' => 'Ticket'
                ],
                'record' => [
                    'id' => $ticketId,
                    'display_name' => $displayName
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }

    public function viewCustomers(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => 'Customers - RSMS',
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ],
            'errors' => $errors,
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewCustomer(Request $request, Response $response, array $args): Response
    {
        $customerId = $args['id'];
        $customer = $this->customerService->getByUuid($customerId);

        $display_name = $customer->getFirstName() . ' ' . $customer->getLastName();

        $data = [
            'zone' => 'workshop',
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

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }

    public function viewDevices(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
            'zone' => 'workshop',
            'page' => [
                'title' => 'Devices - RSMS',
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ]
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewDevice(Request $request, Response $response, array $args): Response
    {
        $errors = $this->session->get('errors');

        $deviceId = $args['id'];
        $device = $this->deviceService->getByUuid($deviceId);

        $display_name = $device->getManufacturer().' '.$device->getModel();

        $data = [
            'zone' => 'workshop',
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
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }
}