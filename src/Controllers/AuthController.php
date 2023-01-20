<?php

/**
 * Handles user authentication and session data.
 * 
 * Author: B Moss
 * Email: <P2595849@my365.dmu.ac.uk>
 * Date: 15/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function loginRedirect(Request $request, Response $response)
    {
        
    }

    public function loginCallback(Request $request, Response $response)
    {
        
    }

    public function logout(Request $request, Response $response)
    {
        
    }
}