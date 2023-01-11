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
        if (!isset($SESSION['username']))
        {
            return $response->withRedirect('/login');
        }
        else
        {
            return $response->withRedirect('/dashboard');
        }
    }

    public function oauth_redirect(Request $request, Response $response)
    {
        $_SESSION['state'] = bin2hex(random_bytes(5));
        $url = $this->okta->buildAuthorizeUrl($_SESSION['state']);

        return $response->withRedirect($url);
    }

    public function oauth_callback(Request $request, Response $response)
    {
        $result = $this->okta->authorizeUser();
        
        if (isset($result['error']))
        {
            $this->logger->error($result['error']);

            return $response->withRedirect('/login');
        }
        else 
        {
            return $response->withRedirect('/dashboard');
        }
    }

    public function logout(Request $request, Response $response)
    {
        session_destroy();

        return $response->withRedirect('/login');
    }
}