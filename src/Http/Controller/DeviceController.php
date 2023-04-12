<?php

/**
 * Devices controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Service\DeviceService;
use App\Service\CustomerService;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;

class DeviceController
{
    private readonly DeviceService $devices;
    private readonly CustomerService $customers;
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->devices = $c->get(DeviceService::class);
        $this->customers = $c->get(CustomerService::class);
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
    }

    /**
     * Returns a list of registered Devices in a table view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $data = [];
        $devices = $this->devices->getAll();

        foreach($devices as &$device)
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
                'cols' => ['Name', 'Serial Number', 'Owner', 'Created', 'Last Updated'],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }

    /**
     * Returns a HTML form for creating a new Device.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function new(Request $request, Response $response): Response
    {


        return $this->twig->render($response, '/app/forms/device_create.html.twig');
    }

    /**
     * Returns a HTML fragment for a single Device.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function show(Request $request, Response $response, array $args): Response
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

        return $this->twig->render($response, '/app/fragments/device_view.html.twig');
    }

    /**
     * Returns a HTML form for editing a Device.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {


        return $this->twig->render($response, '/app/forms/xxx_edit.html.twig');
    }

    /**
     * Creates a new Device account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function create(Request $request, Response $response): Response
    {
        if($this->session->exists('validationErrors'))
        {
            $this->session->delete('validationErrors');
        }

        $body = $request->getParsedBody();

        $validatorRules = [
            'required' => [
                'device.manufacturer',
                'device.model',
                'device.serial',
                'device.imei',
                'device.customer'
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
        ];

        $device = [
            'manufacturer' => $body['device_manufacturer'],
            'model' => $body['device_model'],
            'serial' => $body['device_serial'],
            'imei' => $body['device_imei'],
            'customer' => $body['device_customer']
        ];

        $validator = new Validator([
            'device' => $device
        ]);

        $validator->rules($validatorRules);

        if(!$validator->validate())
        {
            $this->session->store('validationErrors', $validator->errors());

            return $response->withStatus(400);
        }

        $this->devices->create([
            'manufacturer' => $device['manufacturer'],
            'model' => $device['model'],
            'serial' => $device['serial'],
            'imei' => $device['imei'],
            'customer' => $this->customers->getByUuid($device['customer'])
        ]);

        return $response->withStatus(200);
    }
    
    /**
     * Updates the credentials of a Device account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        
    }
    
    /**
     * Deletes the specified Device account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function delete(Request $request, Response $response, array $args): Response
    {
        $uuid = $args['id'];

        $this->devices->delete($uuid);

        return $response->withStatus(200);
    }
}