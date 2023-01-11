<?php

/**
 * Handles admin, user and customer settings views.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 09/01/23
 * 
 * @author B Moss
 */

namespace App\Controllers;

use \Slim\Http\Request;
use \Slim\Http\Response;

class PortalController extends BaseController
{
    public function admin_settings(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Admin Settings - Zenrepair'
        ];

        return $this->twig->render($response, '/app/admin_settings_view.twig', $twig_data);
    }

    public function user_settings(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'User Settings - Zenrepair'
        ];

        return $this->twig->render($response, '/app/user_settings_view.twig', $twig_data);
    }

    public function customer_settings(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Settings - Zenrepair Portal'
        ];

        return $this->twig->render($response, '/portal/settings_view.twig', $twig_data);
    }
}