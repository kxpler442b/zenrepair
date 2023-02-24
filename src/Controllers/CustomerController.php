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

use Slim\Views\Twig;
use App\Services\CustomerService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

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

        return $this->twig->render($response, '/table_view.twig', $twig_data);
    }

    public function viewCustomer(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $customer = $this->customerService->getById($id);

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

        return $this->twig->render($response, '/frags/creators/customer.twig', $twig_data);
    }

    public function getRecord(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $customer = $this->customerService->getById($args['id']);

        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/customers'
            ],
            'record' => [
                'id' => $customer->getId(),
                'first_name' => $customer->getFirstName(),
                'last_name' => $customer->getLastName()
            ]
        ];

        return $this->twig->render($response, '/frags/tables/customer.html', $twig_data);
    }

    public function getTable(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $rows = [];
        $customers = $this->customerService->getAll();

        foreach($customers as &$customer)
        {
            $rows[$customer->getId()->toString()] = array($customer->getFirstName().' '.$customer->getLastName(), [$customer->getEmail(), $customer->getMobile(), ':-)', $customer->getCreated()->format('d-m-Y'), $customer->getUpdated()->format('d-m-Y H:i:s')]);
        }

        $twig_data = [
            'controller' => [
                'base_url' => '/customers',
                'name' => 'customer',
                'Name' => 'Customer'
            ],
            'table' => [
                'headers' => ['Name', 'Email', 'Mobile', 'Devices', 'Date Created', 'Last Updated'],
                'rows' => $rows
            ]
        ];

        return $this->twig->render($response, '/frags/tables/table.html', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}