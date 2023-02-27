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
use Slim\Views\Twig;
use App\Services\CustomerService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CustomerController
{
    private readonly CustomerService $customerProvider;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->customerProvider = $container->get(CustomerProviderInterface::class);
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
            'title' => 'Customers - RSMS',
            'controller' => [
                'base_url' => BASE_URL . '/customers',
                'name' => 'customer',
                'Name' => 'Customer'
            ]
        ];

        return $this->twig->render($response, '/basic_view.twig', $twig_data);
    }

    public function viewCustomer(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $customer = $this->customerProvider->getById($id);

        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'title' => 'Customers - RSMS',
            'record' => [
                'id' => $id,
                'display_name' => $customer->getFirstName().' '.$customer->getLastName()
            ],
            'controller' => [
                'base_url' => BASE_URL . '/customers',
            ]
        ];

        return $this->twig->render($response, 'record_view.twig', $twig_data);
    }

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
        $customer = $this->customerProvider->getById($args['id']);

        $rows = [];
        $devices = $customer->getDevices();

        foreach($devices as &$device)
        {
            $rows[$device->getId()->toString()] = array(
                $device->getSerial(), 
                [
                    $device->getManufacturer().' '.$device->getModel(),
                    $device->getCreated()->format('d-m-Y'),
                    $device->getUpdated()->format('d-m-Y H:i:s')
                ]
            );
        }

        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/customers',
                'devices_url' => BASE_URL . '/devices'
            ],
            'record' => [
                'id' => $customer->getId(),
                'first_name' => $customer->getFirstName(),
                'last_name' => $customer->getLastName(),
                'email' => $customer->getEmail(),
                'mobile' => $customer->getMobile()
            ],
            'table' => [
                'headers' => ['Serial', 'Name', 'Date Created', 'Last Updated'],
                'rows' => $rows
            ]
        ];

        return $this->twig->render($response, '/fragments/tables/customer.html', $twig_data);
    }

    public function getList(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $customers = [];
        $customerArray = $this->customerProvider->getAll();

        foreach($customerArray as &$customer)
        {
            $customers[$customer->getId()->toString()] = array(
                'name' => $customer->getFirstName().' '.$customer->getLastName(),
                'email' => $customer->getEmail(),
                'mobile' => $customer->getMobile(),
                'created' => $customer->getCreated()->format('d-m-Y'),
                'last_updated' => $customer->getUpdated()->format('d-m-Y H:i:s')
            );
        };

        $twig_data = [
            'controller' => [
                'base_url' => '/customers',
                'name' => 'customer',
                'Name' => 'Customer'
            ],
            'customers' => $customers
        ];

        return $this->twig->render($response, '/fragments/lists/customers.html', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}