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
        $deviceId = $args['id'];
        $device = $this->deviceService->getByUuid($deviceId);
        $deviceDisplayName = $device->getManufacturer().' '.$device->getModel();

        $owner = $device->getCustomer();
        $ownerDisplayName = $owner->getFirstName().' '.$owner->getLastName();

        $twig_data = [
            'page' => [
                'record' => [
                    'display_name' => $deviceDisplayName
                ],
            ],
            'device' => [
                'Database ID' => $device->getUuid(),
                'Manufacturer' => $device->getManufacturer(),
                'Model' => $device->getModel(),
                'Serial' => $device->getSerial(),
                'IMEI' => $device->getImei(),
                'Locator' => $device->getLocator()
            ]
        ];

        return $this->twig->render($response, '/read/device.html', $twig_data);
    }

    public function getRecords(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $data = [];
        $deviceArray = $this->deviceService->getAll();

        foreach($deviceArray as &$device)
        {
            $owner = $device->getCustomer();

            $data[$device->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/workshop/device/' . $device->getUuid()->toString(),
                    'text' => $device->getManufacturer().' '.$device->getModel()
                ],
                'serial' => $device->getSerial(),
                'owner' => $owner->getFirstName().' '.$owner->getLastName(),
                'created' => $device->getCreated()->format('d-m-Y H:i:s'),
                'last_updated' => $device->getUpdated()->format('d-m-Y H:i:s')
            );
        }

        $twig_data = [
            'page' => [
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['Name', 'Serial Number', 'Owner', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        
    }
}