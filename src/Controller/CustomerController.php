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
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Service\CustomerService;
use App\Domain\Customer;

class CustomerController
{
    private readonly CustomerService $customerService;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->customerService = $container->get(CustomerService::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function getCreator(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/customer',
                'Name' => 'Customer'
            ],
        ];

        return $this->twig->render($response, '/fragments/creators/customer.twig', $twig_data);
    }

    public function getRecord(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $customerId = $args['id'];
        $customer = $this->customerService->getById($customerId);
        $customerDisplayName = $customer->getFirstName() . ' ' . $customer->getLastName();

        $devices = [];
        $deviceArray = $customer->getDevices();

        foreach($deviceArray as &$device)
        {
            $devices[$device->getId()->toString()] = array(
                'serial' => $device->getSerial(),
                'imei' => $device->getImei(),
                'manufacturer' => $device->getManufacturer(),
                'model' => $device->getModel(),
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
                'Database ID' => $customer->getId(),
                'First Name' => $customer->getFirstName(),
                'Last Name' => $customer->getLastName(),
                'Email Address' => $customer->getEmail(),
                'Mobile Number' => $customer->getMobile()
            ],
            'devices' => [
                'cols' => [
                    'primary' => 'Serial Number',
                    'headers' => ['IMEI', 'Manufacturer', 'Model', 'Created', 'Last Updated']
                ],
                'rows' => $devices
            ]
        ];

        return $this->twig->render($response, '/read/customer.html.twig', $twig_data);
    }

    public function getList(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $data = [];
        $customerArray = $this->customerService->getAll();

        foreach($customerArray as &$customer)
        {
            $data[$customer->getId()->toString()] = array(
                [
                    'link' => BASE_URL . '/view/customer/' . $customer->getId()->toString(),
                    'data' => $customer->getFirstName().' '.$customer->getLastName()
                ],
                'email' => $customer->getEmail(),
                'mobile' => $customer->getMobile(),
                'created' => $customer->getCreated()->format('d-m-Y'),
                'last_updated' => $customer->getUpdated()->format('d-m-Y H:i:s')
            );
        };

        $twig_data = [
            'table' => [
                'cols' => [
                    'primary' => 'Name',
                    'headers' => ['Email Address', 'Mobile Number', 'Created', 'Last Updated']
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