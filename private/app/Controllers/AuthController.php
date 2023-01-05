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
        $this->method = $request->getMethod();

        if ($this->method === 'GET') {

            $twig_data = [
                'css_path' => CSS_PATH,
                'js_path' => JS_PATH,
                'assets_path' => ASSETS_PATH,
                'title' => 'Log In'
            ];
    
            return $this->twig->render($response, '/login/login_view.twig', $twig_data);

        } elseif ($this->method === 'POST') {
            
            // $this->params = $request->getParams();
            //var_dump($this->params);

            return $response->withRedirect('/dashboard');

        }
    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();

        return $response->withRedirect('/login');
    }
}