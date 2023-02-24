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

use App\Contracts\SessionInterface;
use Slim\Views\Twig;
use App\Services\DeviceService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DeviceController
{
    private readonly DeviceService $deviceService;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->deviceService = $container->get(DeviceService::class);
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
            'title' => 'Customers - RSMS',
            'controller' => [
                'base_url' => BASE_URL . '/devices',
                'name' => 'device',
                'Name' => 'Device'
            ]
        ];

        return $this->twig->render($response, '/table_view.twig', $twig_data);
    }

    public function viewRecord(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $device = $this->deviceService->getById($id);

        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'title' => 'Customers - RSMS',
            'record' => [
                'id' => $id,
                'display_name' => $device->getManufacturer().' '.$device->getModel()
            ],
            'controller' => [
                'base_url' => BASE_URL . '/devices',
            ]
        ];

        return $this->twig->render($response, 'record_view.twig', $twig_data);
    }

    public function getCreator(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/devices',
                'Name' => 'Device'
            ],
        ];

        return $this->twig->render($response, '/frags/creators/device.twig', $twig_data);
    }

    public function getTable(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $device = $this->deviceService->getById('8560a131-f3de-4a7f-8738-8c6c30f1db10');

        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/devices',
                'name' => 'device',
                'Name' => 'Device'
            ],
            'table' => [
                'headers' => ['Serial', 'Manufacturer', 'Model', 'IMEI', 'Locator', 'Owner', 'Date Created', 'Last Updated'],
                'rows' => [
                    $device->getId()->toString() => [$device->getSerial(), [$device->getModel(), $device->getManufacturer(), $device->getImei(), $device->getLocator(), ':-)', $device->getCreated()->format('d-m-Y'), $device->getUpdated()->format('d-m-Y H:i:s')]]
                ]
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