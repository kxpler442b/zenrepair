<?php

/**
 * Example controller layout.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 17/02/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\DeviceService;
use App\Service\TicketService;
use App\Interface\SessionInterface;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class TicketController
{
    private readonly LocalAccountService $accountProvider;
    private readonly DeviceService $deviceService;
    private readonly TicketService $ticketService;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->accountProvider = $container->get(LocalAccountProviderInterface::class);
        $this->deviceService = $container->get(DeviceService::class);
        $this->ticketService = $container->get(TicketService::class);
        $this->session = $container->get(SessionInterface::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function getCreator(Request $request, Response $response) : Response
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

    public function getRecord(Request $request, Response $response, array $args) : Response
    {
        $ticketId = $args['id'];
        $ticket = $this->ticketService->getByUuid($ticketId);

        $device = $ticket->getDevice();
        $customer = $ticket->getCustomer();

        $twig_data = [
            'ticket' => [
                'status' => $ticket->getStatus(),
                'details' => [
                    'Job ID' => $ticket->getId(),
                    'Subject' => $ticket->getSubject(),
                    'Issue Type' => $ticket->getIssueType(),
                ]
            ],
            'device' => [
                'link' => BASE_URL . '/workshop/device/' . $device->getUuid()->toString(),
                'details' => [
                    'Manufacturer' => $device->getManufacturer(),
                    'Model' => $device->getModel(),
                    'Serial' => $device->getSerial(),
                    'IMEI' => $device->getImei(),
                    'Locator' => $device->getLocator()
                ] 
            ],
            'customer' => [
                'link' => BASE_URL . '/workshop/customer/' . $customer->getUuid()->toString(),
                'details' => [
                    'First Name' => $customer->getFirstName(),
                    'Last Name' => $customer->getLastName(),
                    'Email Address' => $customer->getEmail(),
                    'Mobile Number' => $customer->getMobile()
                ]
            ],
        ];

        return $this->twig->render($response, '/workshop/fragments/ticket.html.twig', $twig_data);
    }

    public function getRecords(Request $request, Response $response) : Response
    {
        $data = [];
        $ticketsArray = $this->ticketService->getAll();

        foreach($ticketsArray as &$ticket)
        {
            $technician = $ticket->getUser();
            $customer = $ticket->getCustomer();
            $device = $ticket->getDevice();

            $data[$ticket->getUuid()->toString()] = array(
                'id' => $ticket->getId(),
                [
                    'link' => BASE_URL . '/workshop/ticket/' . $ticket->getUuid()->toString(),
                    'text' => $ticket->getSubject()
                ],
                [
                    'link' => BASE_URL . '/workshop/customer/' . $customer->getUuid()->toString(),
                    'text' => $customer->getFirstName().' '.$customer->getLastName()
                ],
                'created' => $ticket->getCreated()->format('d-m-Y'),
                'status' => $ticket->getStatus(),
                'issue_type' => $ticket->getIssueType(),
                'technician' => $technician->getFirstName().' '.$technician->getLastName(),
                'updated' => $ticket->getUpdated()->format('d-m-Y H:i:s')
            );
        }

        $twig_data = [
            'page' => [
                'context' => [
                    'name' => 'ticket',
                    'Name' => 'Ticket'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['#', 'Subject', 'Customer', 'Created', 'Status', 'Issue Type', 'Technician', 'Last Updated']
                ],
                'rows' => $data
            ],
            'errors' => [
                0 => [
                    'error'
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }

    public function update(Request $request, Response $response)
    {
        
    }

    public function delete(Request $request, Response $response)
    {
        
    }
}