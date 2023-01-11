<?php

/**
 * Handles the main application endpoints.
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

class CustomerController extends BaseController
{
    public function customers(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $customers = $this->database->customers->getAllCustomers();

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Customers',
            'user' => [
                'first_name' => 'Benjamin',
                'last_name' => 'Moss'
            ],
            'customers' => $customers
        ];

        return $this->twig->render($response, '/app/customers_view.twig', $twig_data);
    }
}