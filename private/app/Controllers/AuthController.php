<?php

/**
 * Handles user authentication and endpoint protection.
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

class AuthController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        return $response->withRedirect('/login'); // Temporary redirect
    }

    public function login(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Log In'
        ];

        return $this->twig->render($response, '/login/login_view.twig', $twig_data);
    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();

        return $response->withRedirect('/login');
    }
}