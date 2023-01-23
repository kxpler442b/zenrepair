<?php

/**
 * Authentication controller.
 * 
 * Author: B Moss
 * Date: 20/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{
    /**
     * Redirect user based on their authentication status.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function indexRedirect(Request $request, Response $response)
    {
        if (!isset($SESSION['username']))
        {
            return $response->withRedirect('/login');
        }
        else
        {
            return $response->withRedirect('/home');
        }
    }

    /**
     * Redirect the user to the Okta authentication service.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function oktaRedirect(Request $request, Response $response)
    {
        $_SESSION['state'] = bin2hex(random_bytes(5));
        $url = $this->okta->buildAuthorizeUrl($_SESSION['state']);

        return $response->withRedirect($url);
    }

    /**
     * Handle the Okta callback request.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function oktaCallback(Request $request, Response $response)
    {
        $result = $this->okta->authorizeUser();
        
        if (isset($result['error']))
        {
            $this->logger->error($result['error']);

            return $response->withRedirect('/login');
        }
        else 
        {
            return $response->withRedirect('/');
        }
    }

    /**
     * Destroy the user's session and return them to the index route.
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function logout(Request $request, Response $response)
    {
        session_destroy();

        return $response->withRedirect('/login');
    }
}