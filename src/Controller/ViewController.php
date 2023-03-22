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

use App\Interface\LocalAccountProviderInterface;
use App\Interface\SessionInterface;
use App\Service\CustomerService;
use App\Service\DeviceService;
use App\Service\TicketService;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class ViewController
{
    private readonly LocalAccountProviderInterface $users;
    private readonly CustomerService $customerService;
    private readonly DeviceService $deviceService;
    private readonly TicketService $ticketService;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->users = $c->get(LocalAccountProviderInterface::class);
        $this->customerService = $c->get(CustomerService::class);
        $this->deviceService = $c->get(DeviceService::class);
        $this->ticketService = $c->get(TicketService::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);

        $this->addTwigGlobals();
    }

    public function viewCreator(Request $request, Response $response, array $args): Response
    {
        if($args['context'] == 'customer')
        {
            if($this->session->exists('creator'))
            {
                $this->session->delete('creator');
            }

            $this->session->store('creator', [
                'context' => 'customer',
                'step' => 0
            ]);

            $context = [
                'name' => 'customer',
                'Name' => 'Customer'
            ];
        }

        $data = [
            'page' => [
                'title' => 'Create '. $context['Name'],
                'context' => $context
            ],
            'session' => $this->session->get('creator')
        ];

        return $this->twig->render($response, '/create/layout.html.twig', $data);
    }

    public function viewDashboard(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
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
            'sidebar_required' => true,
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
            'sidebar_required' => true,
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

    public function viewUsers(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
            'sidebar_required' => true,
            'page' => [
                'title' => 'Users - RSMS',
                'context' => [
                    'name' => 'user',
                    'Name' => 'User'
                ]
            ],
            'errors' => $errors,
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewUser(Request $request, Response $response, array $args): Response
    {
        $userId = $args['id'];
        $user = $this->users->getAccountByUuid($userId);

        $display_name = $user->getFirstName() . ' ' . $user->getLastName();

        $data = [
            'sidebar_required' => true,
            'page' => [
                'title' => $display_name . ' - RSMS',
                'context' => [
                    'name' => 'user',
                    'Name' => 'User'
                ],
                'record' => [
                    'id' => $userId,
                    'display_name' => $display_name
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }

    public function viewCustomers(Request $request, Response $response): Response
    {
        $errors = $this->session->get('errors');

        $data = [
            'sidebar_required' => true,
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
            'sidebar_required' => true,
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
        $data = [
            'sidebar_required' => true,
            'page' => [
                'title' => 'Devices - RSMS',
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewDevice(Request $request, Response $response, array $args): Response
    {
        $deviceId = $args['id'];
        $device = $this->deviceService->getByUuid($deviceId);

        $display_name = $device->getManufacturer().' '.$device->getModel();

        $data = [
            'sidebar_required' => true,
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

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }

    private function addTwigGlobals()
    {
        $this->twig->getEnvironment()->addGlobal('globals', [
            'debug' => [
                'enabled' => true,
                'phpversion' => phpversion()
            ],
            'base_url' => BASE_URL,
            'favicon_url' => FAVICON_URL,
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL
        ]);
    }
}