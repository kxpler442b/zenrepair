<?php

/**
 * Customer actions controller.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 17/02/23
 */

declare(strict_types = 1);

namespace App\Controller;

use App\Interface\SessionInterface;
use App\Service\AddressService;
use Slim\Views\Twig;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\CustomerService;
use Valitron\Validator;

class CustomerController
{
    private readonly CustomerService $customerService;
    private readonly AddressService $addressService;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->customerService = $container->get(CustomerService::class);
        $this->addressService = $container->get(AddressService::class);
        $this->session = $container->get(SessionInterface::class);

        $this->twig = $container->get(Twig::class);
    }

    /**
     * Create a new customer record.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function create(Request $request, Response $response): Response
    {
        $rules = [
            'required' => [
                'customer.first_name',
                'customer.last_name',
                'customer.email'
            ],
            'alphaNum' => [
                'customer.first_name',
                'customer.last_name'
            ]
        ];

        $body = $request->getParsedBody();

        $customer = [
            'first_name' => $body['first_name'],
            'last_name' => $body['last_name'],
            'email' => $body['email'],
            'mobile' => $body['mobile']
        ];

        $address = null;

        if($body['address_line1'] != null) {
            $address = [
                'line_one' => $body['address_line1'],
                'line_two' => $body['address_line2'],
                'town' => $body['town_city'],
                'county' => $body['county'],
                'postcode' => $body['postcode']
            ];
        }

        if($address == null) {
            $v = new Validator([
                'customer' => $customer
            ]);
        }
        else {
            $v = new Validator([
                'customer' => $customer,
                'address' => $address
            ]);
        }

        $v->rules($rules);

        if($v->validate()) {
            if($this->session->exists('errors')) {
                $this->session->delete('errors');
            }

            $customer = $this->customerService->create([
                'first_name' => $customer['first_name'],
                'last_name' => $customer['last_name'],
                'email' => $customer['email'],
                'mobile' => $customer['mobile']
            ]);

            if($address != null) {
                $this->addressService->create([
                    'line_one' => $address['line_one'],
                    'line_two' => $address['line_two'],
                    'town' => $address['town'],
                    'county' => $address['county'],
                    'postcode' => $address['postcode'],
                    'customer' => $customer
                ]);
            }

            return $response->withHeader('HX-Location', BASE_URL . '/workshop/customers')
                            ->withStatus(302);
        }
        else {
            if($this->session->exists('errors')) {
                $this->session->delete('errors');
            }

            $this->session->store('errors', $v->errors());

            return $response->withHeader('HX-Location', BASE_URL . '/workshop/customers')
                            ->withStatus(302);
        }
    }

    public function getCreateForm(Request $request, Response $response) : Response
    {
        $twig_data = [
            'page' => [
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ], 
            ]
        ];

        return $this->twig->render($response, '/forms/create_customer.html', $twig_data);
    }

    public function getRecord(Request $request, Response $response, array $args) : Response
    {
        $customerId = $args['id'];
        $customer = $this->customerService->getByUuid($customerId);
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

        return $this->twig->render($response, '/workshop/fragments/customer.html', $twig_data);
    }

    public function getRecords(Request $request, Response $response) : Response
    {
        $data = [];
        $customerArray = $this->customerService->getAll();

        foreach($customerArray as &$customer)
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
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['Name', 'Email Address', 'Mobile Number', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }

    public function searchRecords(Request $request, Response $response): Response
    {
        $body= $request->getParsedBody();

        $customer = $this->customerService->getByEmail($body['search']);

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

        $twig_data = [
            'page' => [
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['Name', 'Email Address', 'Mobile Number', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }

    public function update(Request $request, Response $response)
    {
        
    }

    public function delete(Request $request, Response $response, array $args): Response
    {
        $customerId = $args['id'];

        $this->customerService->delete($customerId);

        return $response->withHeader('HX-Location', BASE_URL . '/workshop/customers')
                        ->withStatus(302);
    }
}