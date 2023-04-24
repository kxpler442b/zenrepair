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

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use App\Auth\Contract\AuthProviderContract;

class AuthController
{
    private readonly AuthProviderContract $auth;
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->auth = $c->get(AuthProviderContract::class);
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
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
        if($this->auth->verify())
        {
            return $response->withHeader('Location', implode('', [BASE_URL, '/workshop/dashboard']))->withStatus(302);
        }

        $twigData = [
            'page' => [
                'title' => 'Log in - RSMS'
            ]
        ];

        return $this->twig->render($response, '/auth/auth.html.twig', $twigData);
    }

    /**
     * Tries to authenticate the user.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function login(Request $request, Response $response): Response
    {
        $this->auth->clear();

        $body = $request->getParsedBody();

        $validatorRules = [
            'required' => [
                'user.email',
                'user.password'
            ],
            'email' => [
                'user.email'
            ]
        ];

        $user = [
            'email' => $body['email'],
            'password' => $body['password']
        ];

        $v = new Validator([
            'user' => $user
        ]);

        $v->rules($validatorRules);

        if(!$v->validate())
        {
            return $response->withHeader('HX-Location', BASE_URL)->withStatus(302);
        }

        if(!$this->auth->login($user['email'], $user['password']))
        {
            return $response->withHeader('HX-Location', BASE_URL)->withStatus(302);
        }

        return $response->withHeader('HX-Location', implode('', [BASE_URL, '/workshop/view/dashboard']))->withStatus(302);
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
        $this->auth->clear();

        return $response->withHeader('Location', BASE_URL)->withStatus(302);
    }
}