<?php

/**
 * Authentication controller.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use Auth0\SDK\Auth0;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class AuthController
{
    private readonly Auth0 $auth0;
    private ?object $session;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->auth0 = $c->get(Auth0::class);
        $this->session = null;
    }

    /**
     * Checks if the User is authenticated and redirects them.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $this->session = $this->auth0->getCredentials();

        if($this->session === null)
        {
            return $response->withHeader('Location', BASE_URL . '/login')
                            ->withStatus(302);
        }

        return $response->withHeader('Location', BASE_URL . '/workshop/dashboard')
                        ->withStatus(302);
    }

    /**
     * Redirects the User to the Auth0 service.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $this->auth0->clear();

        return $response->withHeader('Location', $this->auth0->login(BASE_URL . '/callback'))
                            ->withStatus(302); 
    }

    /**
     * Handles the response from the Auth0 service.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function callback(Request $request, Response $response): Response
    {
        $this->auth0->exchange(BASE_URL . '/callback');

        return $response->withHeader('Location', BASE_URL . '/workshop/dashboard')
                        ->withStatus(302);
    }

    /**
     * Clears the User's authenticated session and redirects them.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function logout(Request $request, Response $response)
    {
        $this->auth0->clear();

        return $response->withHeader('Location', BASE_URL . '/login')
                        ->withStatus(302);
    }
}