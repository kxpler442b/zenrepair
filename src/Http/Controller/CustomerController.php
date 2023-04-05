<?php

/**
 * Customers controller.
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
use Valitron\Validator;
use App\Service\CustomerService;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;

class CustomerController
{
    private readonly CustomerService $customers;
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->customers = $c->get(CustomerService::class);
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
    }

    /**
     * Returns a list of registered Customers in a table view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $data = [];
        $customers = $this->customers->getAll();

        foreach($customers as &$customer)
        {
            $data[$customer->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/workshop/customer/' . $customer->getUuid()->toString(),
                    'text' => $customer->getFirstName().' '.$customer->getLastName()
                ],
                'email' => $customer->getEmail(),
                'mobile' => $customer->getMobile(),
                'created' => $customer->getCreated()->format('d-m-Y'),
                'last_updated' => $customer->getUpdated()->format('d-m-Y H:i:s')
            );
        };

        $twig_data = [
            'page' => [
                'title' => 'Customers',
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['Name', 'Email Address', 'Group', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/app/fragments/table.html.twig', $twig_data);
    }

    /**
     * Returns a HTML form for creating a new Customer.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function new(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Customers'
            ]
        ];

        return $this->twig->render($response, '/app/forms/customer_create.html.twig');
    }

    /**
     * Returns a HTML fragment for a single Customer.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function show(Request $request, Response $response, array $args): Response
    {
        $customerId = $args['id'];
        $customer = $this->customers->getByUuid($customerId);
        $customerDisplayName = $customer->getFirstName() . ' ' . $customer->getLastName();

        $addresses = [];
        $addressArray = $customer->getAddresses();

        foreach($addressArray as &$address)
        {
            $addresses[$address->getUuid()->toString()] = array(
                'Line One' => $address->getLineOne(),
                'Line Two' => $address->getLineTwo(),
                'Town / City' => $address->getTown(),
                'County' => $address->getCounty(),
                'Postcode' => $address->getPostcode()
            );
        }

        $devices = [];
        $deviceArray = $customer->getDevices();

        foreach($deviceArray as &$device)
        {
            $devices[$device->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/workshop/device/' . $device->getUuid()->toString(),
                    'text' => $device->getManufacturer().' '.$device->getModel()
                ],
                'serial' => $device->getSerial(),
                'imei' => $device->getImei(),
                'created' => $device->getCreated()->format('d-m-Y H:i:s'),
                'last_updated' => $device->getUpdated()->format('d-m-Y H:i:s')
            );
        }

        $twig_data = [
            'page' => [
                'record' => [
                    'display_name' => $customerDisplayName
                ],
            ],
            'customer' => [
                'id' => $customer->getUuid()->toString(),
                'details' => [
                    'First Name' => $customer->getFirstName(),
                    'Last Name' => $customer->getLastName(),
                    'Email Address' => $customer->getEmail(),
                    'Mobile Number' => $customer->getMobile()
                ]
            ],
            'addresses' => $addresses,
            'devices' => [
                'cols' => [
                    'headers' => ['Device Name', 'Serial Number', 'IMEI', 'Created', 'Last Updated']
                ],
                'rows' => $devices
            ]
        ];

        return $this->twig->render($response, '/app/fragments/customer_view.html.twig', $twig_data);
    }

    /**
     * Returns a HTML form for editing a Customer.
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
                'title' => 'Customers'
            ]
        ];

        return $this->twig->render($response, '/app/forms/customer_edit.html.twig');
    }

    /**
     * Creates a new Customer account.
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
                'customer.forename',
                'customer.familyname',
                'customer.email',
                'customer.mobile'
            ],
            'alphaNum' => [
                'customer.forename',
                'customer.familyname'
            ],
            'email' => 'customer.email'
        ];

        $customer = [
            'forename' => $body['customer_forename'],
            'familyname' => $body['customer_familyname'],
            'email' => $body['customer_email'],
            'mobile' => $body['customer_mobile']
        ];

        $validator = new Validator([
            'customer' => $customer
        ]);

        $validator->rules($validatorRules);

        if(!$validator->validate())
        {
            $this->session->store('validationErrors', $validator->errors());
            
            return $response->withStatus(400);
        }

        $this->customers->create([
            'first_name' => $customer['forename'],
            'last_name' => $customer['familyname'],
            'email' => $customer['email'],
            'mobile' => $customer['mobile']
        ]);

        return $response->withStatus(200);
    }
    
    /**
     * Updates the credentials of a Customer account.
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
     * Deletes the specified Customer account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $uuid = $args['id'];

        $this->customers->delete($uuid);

        return $response->withStatus(200);
    }
}