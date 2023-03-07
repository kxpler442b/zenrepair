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
use App\Service\DeviceService;
use App\Service\TicketService;
use App\Interface\SessionInterface;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
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
        $data = [];
        $ticketsArray = $this->ticketService->getAll();

        foreach($ticketsArray as &$ticket)
        {
            $technician = $ticket->getUser();
            $device = $ticket->getDevice();

            $data[$ticket->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/view/ticket/' . $ticket->getUuid()->toString(),
                    'data' => $ticket->getSubject()
                ],
                'issue_type' => $ticket->getIssueType(),
                'status' => $ticket->getStatus(),
                [
                    'link' => BASE_URL . '/view/device/' . $device->getUuid()->toString(),
                    'data' => $device->getSerial(),
                ],
                'technician' => $technician->getFirstName().' '.$technician->getLastName(),
                'created' => $ticket->getCreated()->format('d-m-Y H:i:s'),
                'updated' => $ticket->getUpdated()->format('d-m-Y H:i:s')
            );
        }

        $twig_data = [
            'table' => [
                'cols' => [
                    'primary' => 'Subject',
                    'headers' => ['Issue Type', 'Status', 'Device', 'Assigned Technician', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/read/table.html.twig', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}