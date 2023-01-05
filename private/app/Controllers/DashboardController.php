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

class DashboardController extends BaseController
{
    public function dashboard(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Dashboard',
            'user' => [
                'first_name' => 'Benjamin',
                'last_name' => 'Moss'
            ]
        ];

        return $this->twig->render($response, '/app/dashboard_view.twig', $twig_data);
    }
}