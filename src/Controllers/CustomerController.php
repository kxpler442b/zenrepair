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
            'css_path' => CSS_URI,
            'title' => 'Customers - RSMS',
            'category' => [
                'url' => 'customers',
                'singularName' => 'Customer'
            ]
        ];

        return $this->render($response, '/category_view.twig', $twig_data);
    }
}