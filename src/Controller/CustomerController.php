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
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\CustomerService;

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

    public function create(Request $request, Response $response)
    {
        $this->customerService->create([
            'first_name' => $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'email' => $_POST['email'],
            'mobile' => $_POST['mobile']
        ]);

        return $response->withHeader('Location', BASE_URL . '/view/customers')
                        ->withStatus(302);
    }

    public function getCreator(Request $request, Response $response) : Response
    {
        $twig_data = [
            'page' => [
                'context' => [
                    'name' => 'customer',
                    'Name' => 'Customer'
                ]
            ]
        ];

        return $this->twig->render($response, '/create/customer.html', $twig_data);
    }

    public function getRecord(Request $request, Response $response, array $args) : Response
    {
        $customerId = $args['id'];
        $customer = $this->customerService->getByUuid($customerId);
        $customerDisplayName = $customer->getFirstName() . ' ' . $customer->getLastName();

        $devices = [];
        $deviceArray = $customer->getDevices();

        foreach($deviceArray as &$device)
        {
            $devices[$device->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/view/device/' . $device->getUuid()->toString(),
                    'data' => $device->getManufacturer().' '.$device->getModel()
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
                'Database ID' => $customer->getUuid()->toString(),
                'First Name' => $customer->getFirstName(),
                'Last Name' => $customer->getLastName(),
                'Email Address' => $customer->getEmail(),
                'Mobile Number' => $customer->getMobile()
            ],
            'devices' => [
                'cols' => [
                    'primary' => 'Device Name',
                    'headers' => ['Serial Number', 'IMEI', 'Created', 'Last Updated']
                ],
                'rows' => $devices
            ]
        ];

        return $this->twig->render($response, '/read/customer.html.twig', $twig_data);
    }

    public function getList(Request $request, Response $response) : Response
    {
        $data = [];
        $customerArray = $this->customerService->getAll();

        foreach($customerArray as &$customer)
        {
            $data[$customer->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/view/customer/' . $customer->getUuid()->toString(),
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

    public function update(Request $request, Response $response)
    {
        
    }

    public function delete(Request $request, Response $response, array $args)
    {
        $customerId = $args['id'];

        $this->customerService->delete($customerId);

        return $response->withHeader('Location', BASE_URL . '/view/customers')
                        ->withStatus(302);
    }
}