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

    private string $context = 'device';

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
                    'link' => BASE_URL . '/workshop/view/device/' . $device->getUuid()->toString(),
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
                    'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                    'name' => $this->context,
                    'Name' => ucwords($this->context)
                ],
            ],
            'table' => [
                'cols' => ['Name', 'Serial Number', 'Owner', 'Created', 'Last Updated'],
                'rows' => $data
            ],
            'validationErrors' => $this->session->get('validationErrors')
        ];

        return $this->twig->render($response, '/workshop/list/fragments/table.html', $twig_data);
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
        $twigData = [
            'page' => [
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                    'name' => $this->context,
                    'Name' => ucwords($this->context)
                ],
            ]
        ];

        return $this->twig->render($response, '/workshop/create/fragments/device.html', $twigData);
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

        $context = 'device';

        $twigData = [
            'page' => [
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $context, 's']),
                    'name' => implode('', [$context, 's']),
                    'Name' => ucwords(implode('', [$context, 's']))
                ],
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
                'link' => BASE_URL . '/workshop/view/customer/' . $owner->getUuid()->toString(),
                'name' => $owner->getFirstName().' '.$owner->getLastName()
            ]
        ];

        return $this->twig->render($response, '/workshop/single/fragments/device.html', $twigData);
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
                'device.locator',
                'device.customer'
            ],
            'requiredWith' => [
                ['device.manufacturer', 'device.model']
            ],
            'alphaNum' => [
                'device.manufacturer',
                'device.serial',
                'device.imei',
                'device.locator'
            ],
            'lengthMin' => [
                ['device.imei', 13]
            ],
            'lengthMax' => [
                ['device.manufacturer', 64],
                ['device.model', 64],
                ['device.serial', 32],
                ['device.imei', 16],
                ['device.locator', 16]
            ],
        ];

        $device = [
            'manufacturer' => $body['device_manufacturer'],
            'model' => $body['device_model'],
            'serial' => $body['device_serial'],
            'imei' => $body['device_imei'],
            'locator' => $body['device_locator'],
            'customer' => $body['device_customer']
        ];

        $validator = new Validator([
            'device' => $device
        ]);

        $validator->rules($validatorRules);

        if(!$validator->validate())
        {
            $this->session->store('validationErrors', $device);

            return $response->withHeader('HX-Location', implode('', [BASE_URL, '/workshop/view/devices']))->withStatus(400);
        }

        $this->devices->create([
            'manufacturer' => $device['manufacturer'],
            'model' => $device['model'],
            'serial' => $device['serial'],
            'imei' => $device['imei'],
            'locator' => $device['locator'],
            'owner' => $this->customers->getByUuid($device['customer'])
        ]);

        return $response->withHeader('HX-Location', implode('', [BASE_URL, '/workshop/view/devices']))->withStatus(200);
    }

    /**
     * Search the database for a given record and return a HTML fragment using the specified format.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function search(Request $request, Response $response, array $args): Response
    {
        $format = $args['format'];
        $search = $request->getParsedBody()['search'];

        if($format == 'select')
        {
            $devices = [];
            $results = $this->devices->search($search);

            foreach($results as &$device)
            {
                $devices[$device->getUuid()->toString()] = array(
                    'display_name' => $device->getManufacturer().' '.$device->getModel(),
                    'identifier' => $device->getSerial()
                );
            };

            $twigData = [
                'options' => $devices
            ];

            return $this->twig->render($response, '/workshop/search/select.html', $twigData);
        }
        if($format == 'table')
        {
            $devices = [];
            $results = $this->devices->search($search);

            foreach($results as &$device)
            {
                $owner = $device->getCustomer();

                $devices[$device->getUuid()->toString()] = array(
                    [
                        'link' => BASE_URL . '/workshop/view/device/' . $device->getUuid()->toString(),
                        'text' => $device->getManufacturer().' '.$device->getModel()
                    ],
                    'serial' => $device->getSerial(),
                    'owner' => $owner->getFirstName().' '.$owner->getLastName(),
                    'created' => $device->getCreated()->format('d-m-Y H:i:s'),
                    'last_updated' => $device->getUpdated()->format('d-m-Y H:i:s')
                );
            }

            $twigData = [
                'page' => [
                    'title' => 'Devices',
                    'context' => [
                        'endpoint' => implode('', [BASE_URL, '/', $this->context, 's']),
                        'name' => implode('', [$this->context, 's']),
                        'Name' => ucwords(implode('', [$this->context, 's']))
                    ],
                ],
                'table' => [
                    'cols' => ['Name', 'Serial Number', 'Owner', 'Created', 'Last Updated'],
                    'rows' => $devices
                ],
            ];

            return $this->twig->render($response, '/workshop/search/table.html', $twigData);
        }

        return $response->withStatus(400);
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

        return $response->withHeader('HX-Redirect', BASE_URL . '/workshop/view/devices')->withStatus(200);
    }
}