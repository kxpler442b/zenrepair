<?php

/**
 * Customer Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class CustomerController extends Controller
{
    public function customersView(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_URL,
            'assets_path' => ASSETS_URL,
            'title' => 'Customers - RSMS',
            'category' => [
                'url' => 'customers',
                'singularName' => 'Customer',
                'table' => [
                    'headers' => ['First Name', 'Last Name', 'Email', 'Mobile', 'Date Created', 'Last Updated'],
                    'rows' => [
                        0 => ['Eugene', 'Krabs', 'eugene.krabs@email.com', '07123456789', '01-01-2023 12:00', '01-01-2023 12:00'],
                        1 => ['Kermit', 'Frog', 'kermit.frog@email.com', '07123456789', '01-01-2023 12:00', '01-01-2023 12:00'],
                    ]
                ]
            ]
        ];

        return $this->render($response, '/category_view.twig', $twig_data);
    }
}