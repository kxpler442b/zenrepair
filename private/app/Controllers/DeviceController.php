<?php

/**
 * Handles the Device views.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 05/01/23
 * 
 * @author B Moss
 */

namespace App\Controllers;

use \Slim\Http\Request;
use \Slim\Http\Response;

class DeviceController extends BaseController
{
    public function devices_view(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $devices = $this->database->devices->getAllDevices();

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Devices',
            'devices' => $devices
        ];

        return $this->twig->render($response, '/app/devices/devices_view.twig', $twig_data);
    }

    public function device_view(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $device = $this->database->devices->getDevice($args['id']);

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'View Device - RSMS',
            'device' => $device[0]
        ];

        return $this->twig->render($response, '/app/devices/device_view.twig', $twig_data);
    }
}