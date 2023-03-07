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

use App\Interface\LocalAccountProviderInterface;
use Slim\Views\Twig;
use App\Service\DeviceService;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DeviceController
{
    private readonly LocalAccountService $accountProvider;
    private readonly DeviceService $deviceService;
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

        return $this->twig->render($response, '/basic_view.twig', $twig_data);
    }

    public function viewRecord(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $id = $args['id'];
        $device = $this->deviceService->getByUuid($id);

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

        return $this->twig->render($response, '/fragments/creators/device.twig', $twig_data);
    }

    public function getRecord(RequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $device = $this->deviceService->getByUuid($args['id']);
        $owner = $device->getCustomer();

        $twig_data = [
            'controller' => [
                'base_url' => BASE_URL . '/devices'
            ],
            'record' => [
                'id' => $device->getUuid(),
                'manufacturer' => $device->getManufacturer(),
                'model' => $device->getModel(),
                'serial' => $device->getSerial(),
                'imei' => $device->getImei(),
                'owner' => [
                    'name' => $owner->getFirstName().' '.$owner->getLastName()
                ],
                'ticket' => [
                    'id' => '7b249ecb-58a5-4571-bb70-ed2281b38ac3',
                    'subject' => 'Screen Replacement'
                ]
            ]
        ];

        return $this->twig->render($response, '/fragments/tables/device.html', $twig_data);
    }

    public function getList(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $data = [];
        $deviceArray = $this->deviceService->getAll();

        foreach($deviceArray as &$device)
        {
            $owner = $device->getCustomer();

            $data[$device->getUuid()->toString()] = array(
                'name' => $device->getManufacturer().' '.$device->getModel(),
                'serial' => $device->getSerial(),
                'owner' => $owner->getFirstName().' '.$owner->getLastName(),
                'created' => $device->getCreated()->format('d-m-Y H:i:s'),
                'last_updated' => $device->getUpdated()->format('d-m-Y H:i:s')
            );
        }

        $twig_data = [
            'table' => [
                'cols' => [
                    'primary' => 'Name',
                    'headers' => ['Serial Number', 'Owner', 'Created', 'Last Updated']
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