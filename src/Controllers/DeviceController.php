<?php

/**
 * Devices Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DeviceController extends Controller
{
    public function devicesView(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_URI,
            'title' => 'Devices - RSMS',
            'category' => [
                'url' => 'devices',
                'singularName' => 'Device'
            ]
        ];

        return $this->render($response, '/category_view.twig', $twig_data);
    }
}