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
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\DeviceService;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;
use App\Interface\SessionInterface;
use Valitron\Validator;

class DeviceController
{
    private readonly LocalAccountService $users;
    private readonly DeviceService $devices;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $c)
    {
        $this->users = $c->get(LocalAccountProviderInterface::class);
        $this->devices = $c->get(DeviceService::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function create(Request $request, Response $response): Response
    {
        $rules = array(
            'required' => [
                'device.manufacturer',
                'device.model',
                'device.serial',
                'device.imei'
            ],
            'requiredWith' => [
                ['device.manufacturer', 'device.model']
            ],
            'alphaNum' => [
                'device.manufacturer',
                'device.serial',
                'device.imei'
            ],
            'lengthMin' => [
                ['device.imei', 13]
            ],
            'lengthMax' => [
                ['device.manufacturer', 64],
                ['device.model', 64],
                ['device.serial', 32],
                ['device.imei', 16]
            ],
        );

        $formData = $request->getParsedBody();

        $device = array(
            'manufacturer' => $formData['device_manufacturer'],
            'model' => $formData['device_model'],
            'serial' => $formData['device_serial'],
            'imei' => $formData['device_imei'],
            'locator' => $formData['device_locator']
        );

        $v = new Validator([
            'device' => $device
        ]);

        $v->rules($rules);

        if($v->validate()) {

            if($this->session->exists('errors')) {
                $this->session->delete('errors');
            }

            $this->devices->create($device);

            return $response->withHeader('HX-Location', BASE_URL . '/workshop/devices')
                            ->withStatus(302);
        }
        else {

            if($this->session->exists('errors')) {
                $this->session->delete('errors');
            }

            $this->session->store('errors', $v->errors());

            return $response->withHeader('HX-Location', BASE_URL . '/workshop/devices')
                            ->withStatus(302);
        }
    }

    public function getCreateForm(Request $request, Response $response): Response
    {
        $data = [
            'page' => [
                'context' => [
                    'name' => 'device',
                    'Name' => 'Device'
                ]
            ]
        ];

        return $this->twig->render($response, '/forms/create_device.html', $data);
    }

    public function getRecord(Request $request, Response $response, array $args) : Response
    {
        $deviceId = $args['id'];
        $device = $this->devices->getByUuid($deviceId);
        $deviceDisplayName = $device->getManufacturer() . ' ' . $device->getModel();

        $owner = $device->getCustomer();

        $twig_data = [
            'page' => [
                'record' => [
                    'display_name' => $deviceDisplayName
                ],
            ],
            'device' => [
                'id' => $device->getUuid()->toString(),
                'details' => [
                    'Manufacturer' => $device->getManufacturer(),
                    'Model' => $device->getModel(),
                    'Serial Number' => $device->getSerial(),
                    'IMEI' => $device->getImei(),
                    'Locator' => $device->getLocator()
                ]
            ],
            'owner' => [
                'link' => BASE_URL . '/workshop/customer/' . $owner->getUuid()->toString(),
                'details' => [
                    'Name' => $owner->getFirstName().' '.$owner->getLastName()
                ] 
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/device.html.twig', $twig_data);
    }

    public function getRecords(Request $request, Response $response) : Response
    {
        $data = [];
        $deviceArray = $this->devices->getAll();

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

    public function update(Request $request, Response $response)
    {
        
    }

    public function delete(Request $request, Response $response)
    {
        
    }
}