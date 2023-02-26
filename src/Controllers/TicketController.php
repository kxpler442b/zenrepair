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

use App\Contracts\CustomerProviderInterface;
use App\Contracts\DeviceProviderInterface;
use Slim\Views\Twig;
use App\Services\TicketService;
use App\Contracts\SessionInterface;
use App\Contracts\TicketProviderInterface;
use App\Contracts\UserProviderInterface;
use App\Services\CustomerService;
use App\Services\DeviceService;
use App\Services\UserService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class TicketController
{
    private readonly UserService $userProvider;
    private readonly CustomerService $customerProvider;
    private readonly DeviceService $deviceProvider;
    private readonly TicketService $ticketProvider;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->userProvider = $container->get(UserProviderInterface::class);
        $this->customerProvider = $container->get(CustomerProviderInterface::class);
        $this->deviceProvider = $container->get(DeviceProviderInterface::class);
        $this->ticketProvider = $container->get(TicketProviderInterface::class);
        $this->session = $container->get(SessionInterface::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    /**
     * Full table view.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * 
     * @return ResponseInterface
     */
    public function index(RequestInterface $request, ResponseInterface $response) : ResponseInterface
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

        return $this->twig->render($response, '/basic_view.twig', $twig_data);
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
        if(!$this->session->exists('creator_state'))
        {
            $this->session->store('creator_state', 0);
        }

        var_dump($this->session->get('creator_state'));

        $twig_data = [
            'creator' => [
                'state' => $this->session->get('creator_state')
            ],
            'controller' => [
                'base_url' => BASE_URL . '/tickets',
                'Name' => 'Ticket'
            ],
        ];

        return $this->twig->render($response, '/frags/creators/ticket.twig', $twig_data);
    }

    public function getCreatorNext(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        if(!$this->session->exists('creator_state'))
        {
            $this->session->store('creator_state', 0);
        }

        var_dump($this->session->get('creator_state'));

        $twig_data = [
            'creator' => [
                'state' => $this->session->get('creator_state')
            ],
            'controller' => [
                'base_url' => BASE_URL . '/tickets',
                'Name' => 'Ticket'
            ],
        ];

        return $this->twig->render($response, '/frags/creators/table.twig', $twig_data);
    }

    public function getList(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $tickets = [];
        $ticketsArray = $this->ticketProvider->getAll();

        foreach($ticketsArray as &$ticket)
        {
            $device = $ticket->getDevice();
            $customer = $ticket->getCustomer();

            $tickets[$ticket->getId()->toString()] = array(
                'title' => $ticket->getTitle(),
                'status' => $ticket->getStatus(),
                'device' => $device->getManufacturer().' '.$device->getModel(),
                'customer' => $customer->getFirstName().' '.$customer->getLastName(),
                'last_updated' => $ticket->getUpdated()->format('d-m-Y H:i:s')
            );
        };

        $twig_data = [
            'controller' => [
                'base_url' => '/customers',
                'name' => 'ticket',
                'Name' => 'Customer'
            ],
            'tickets' => $tickets
        ];

        return $this->twig->render($response, '/fragments/lists/tickets.html', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}