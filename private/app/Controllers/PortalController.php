<?php

/**
 * Handles customer sessions for the portal.
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

class PortalController extends BaseController
{
    public function login_view(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Log In',
            'company_name' => 'FixYourPhone'
        ];

        return $this->twig->render($response, '/portal/login_view.twig', $twig_data);
    }

    public function login_handler(Request $request, Response $response)
    {
        $this->params = $request->getParams();

        var_dump($this->params);
    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();

        return $response->withRedirect('/portal');
    }
}