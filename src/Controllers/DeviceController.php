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
use App\Services\DeviceService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DeviceController
{
    private readonly ContainerInterface $container;
    private readonly DeviceService $deviceService;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->deviceService = $container->get(DeviceService::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL,
            'title' => 'Devices - RSMS',
            'controller' => [
                'base_url' => '/devices',
                'name' => 'device',
                'Name' => 'Device'
            ]
        ];

        return $this->twig->render($response, '/table_view.twig', $twig_data);
    }

    public function create(RequestInterface $request, ResponseInterface $response)
    {

    }

    public function getTable(RequestInterface $request, ResponseInterface $response)
    {
        $device = $this->deviceService->getById('8560a131-f3de-4a7f-8738-8c6c30f1db10');

        $twig_data = [
            'controller' => [
                'name' => 'device'
            ],
            'table' => [
                'headers' => ['Serial', 'Manufacturer', 'Model', 'IMEI', 'Locator', 'Owner', 'Date Created', 'Last Updated'],
                'rows' => [
                    $device->getId()->toString() => [$device->getSerial(), [$device->getModel(), $device->getManufacturer(), $device->getImei(), $device->getLocator(), ':-)', $device->getCreated()->format('d-m-Y'), $device->getUpdated()->format('d-m-Y H:i:s')]]
                ]
            ]
        ];

        return $this->twig->render($response, '/frags/table.html', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}