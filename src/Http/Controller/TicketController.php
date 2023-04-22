<?php

/**
 * Tickets controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use App\Interface\SessionInterface;
use App\Service\CustomerService;
use App\Service\DeviceService;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\TicketService;
use App\Service\UserService;
use Psr\Container\ContainerInterface;
use Valitron\Validator;

class TicketController
{
    private readonly TicketService $tickets;
    private readonly UserService $users;
    private readonly CustomerService $customers;
    private readonly DeviceService $devices;
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    private string $context = 'ticket';

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->tickets = $c->get(TicketService::class);
        $this->users = $c->get(UserService::class);
        $this->customers = $c->get(CustomerService::class);
        $this->devices = $c->get(DeviceService::class);
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
    }

    /**
     * Returns a formatted table of Tickets as a HTML fragment.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $data = [];
        $tickets = $this->tickets->getAll();

        foreach($tickets as &$ticket)
        {
            $technician = $ticket->getUser();
            $customer = $ticket->getCustomer();

            $data[$ticket->getUuid()->toString()] = array(
                'id' => $ticket->getId(),
                [
                    'link' => BASE_URL . '/workshop/view/ticket/' . $ticket->getUuid()->toString(),
                    'text' => $ticket->getSubject()
                ],
                [
                    'link' => BASE_URL . '/workshop/view/customer/' . $customer->getUuid()->toString(),
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
                'cols' => ['#', 'Subject', 'Customer', 'Created', 'Status', 'Issue Type', 'Technician', 'Last Updated'],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/workshop/list/fragments/table.html', $twig_data);
    }

    /**
     * Returns a HTML form for creating a new Ticket.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function new(Request $request, Response $response): Response
    {
        $twigData = [
            'page' => [
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                    'name' => implode('', [$this->context, 's']),
                    'Name' => ucwords(implode('', [$this->context, 's']))
                ]
            ],
        ];

        return $this->twig->render($response, '/workshop/create/fragments/ticket.html', $twigData);
    }

    /**
     * Returns a HTML fragment for a single Ticket.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $ticketId = $args['id'];
        $ticket = $this->tickets->getByUuid($ticketId);

        $device = $ticket->getDevice();
        $customer = $ticket->getCustomer();

        $this->context = 'ticket';

        $twigData = [
            'page' => [
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                    'name' => implode('', [$this->context, 's']),
                    'Name' => ucwords(implode('', [$this->context, 's']))
                ],
                'record' => [
                    'display_name' => implode(' ', [$ticket->getSubject(), 'for', $customer->getFirstName(), $customer->getLastName()])
                ]
            ],
            'ticket' => [
                'status' => $ticket->getStatus(),
                'jobId' => $ticket->getId(),
                'subject' => $ticket->getSubject(),
                'issueType' => $ticket->getIssueType(),
            ],
            'device' => [
                'link' => BASE_URL . '/workshop/device/' . $device->getUuid()->toString(),
                'manufacturer' => $device->getManufacturer(),
                'model' => $device->getModel(),
                'serial' => $device->getSerial(),
                'imei' => $device->getImei(),
                'locator' => $device->getLocator()
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

        return $this->twig->render($response, '/workshop/single/fragments/ticket.html', $twigData);
    }

    /**
     * Returns a HTML form for editing a Ticket.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Tickets'
            ]
        ];

        return $this->twig->render($response, '/app/forms/ticket_edit.html.twig');
    }

    /**
     * Creates a new Ticket.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function create(Request $request, Response $response): Response
    {
        if($this->session->exists('validationErrors'))
        {
            $this->session->delete('validationErrors');
        }

        $body = $request->getParsedBody();

        $validatorRules = [
            'required' => [
                'ticket.subject',
                'ticket.issue_type',
                'ticket.user',
                'ticket.customer',
                'ticket.device',
            ],
            'alphaNum' => [
                'ticket.subject'
            ]
        ];

        $ticket = [
            'subject' => $body['ticket_subject'],
            'issue_type' => $body['ticket_issueType'],
            'user' => $body['ticket_user'],
            'customer' => $body['ticket_customer'],
            'device' => $body['ticket_device']
        ];

        $validator = new Validator([
            'ticket' => $ticket
        ]);

        $validator->rules($validatorRules);

        if(!$validator->validate())
        {
            $this->session->store('validationErrors', $validator->errors());

            return $response->withStatus(400);
        }

        $this->tickets->create([
            'subject' => $ticket['subject'],
            'issue_type' => $ticket['issue_type'],
            'user' => $this->users->getByUuid($ticket['user']),
            'customer' => $this->customers->getByUuid($ticket['customer']),
            'device' => $this->devices->getByUuid($ticket['device'])
        ]);

        return $response->withStatus(200);
    }
    
    /**
     * Updates the credentials of a Ticket account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        
    }
    
    /**
     * Deletes the specified Ticket account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $uuid = $args['id'];

        $this->tickets->delete($uuid);

        return $response->withStatus(200);
    }
}