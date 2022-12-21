<?php

/**
 * AuthController.php
 * 
 * Handles user authentication and redirection.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

declare(strict_types=1);

namespace App\Controllers;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

use Psr\Container\ContainerInterface;

class AuthController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $this->container->get('view');
    }

    public function __destruct() {}

    public function index(Request $request, Response $response)
    {
        if (isset($_SESSION['username'])) {
            return $response->withRedirect('/dashboard');
        } else {
            return $response->withRedirect('/login');
        }
    }

    public function login(Request $request, Response $response, array $args)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Log In'
        ];

        return $this->view->render($response, '/auth/auth_view.twig', $twig_data);
    }

    public function logout(Request $request, Response $response)
    {

    }
}