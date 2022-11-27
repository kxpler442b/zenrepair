<?php

/**
 * authController.php
 * 
 * handles user authentication and pre-routing
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

declare(strict_types=1);

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller
{
    public function index(Request $request, Response $response, array $args)
    {
        return $this->view->render($response, 'auth_login_view.twig', [
            'css_path' => CSS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Log In'
        ]);
    }
}