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
    public function customers_data(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $customers = $this->database->customers->getAllCustomers('*');

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Customers - RSMS',
            'customers' => $customers
        ];

        return $this->twig->render($response, '/app/customers/data_view.twig', $twig_data);
    }

    public function customers_create(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Create Customer - RSMS'
        ];


        return $this->twig->render($response, '/app/customers/create_view.twig', $twig_data);
    }

    public function customers_commit(Request $request, Response $response)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $this->database->customers->createCustomer($request->getParams());

        return $response->withRedirect('/customers');
    }

    public function customer_view(Request $request, Response $response, array $args)
    {
        if (!$this->okta->checkAuthStatus())
        {
            return $response->withRedirect('/login');
        }

        $customer = $this->database->customers->getCustomer($args['id']);

        $twig_data = [
            'css_path' => '/css',
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'View Customer - RSMS',
            'customer' => $customer[0]
        ];

        return $this->twig->render($response, '/app/customers/customer_view.twig', $twig_data);
    }
}