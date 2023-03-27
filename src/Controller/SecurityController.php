<?php

/**
 * Authentication Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Valitron\Validator;
use App\Interface\AuthInterface;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class SecurityController
{
    private readonly AuthInterface $auth;
    private readonly LocalAccountProviderInterface $users;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $c)
    {
        $this->auth = $c->get(AuthInterface::class);
        $this->users = $c->get(LocalAccountProviderInterface::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);

        $this->addTwigGlobals();
    }

    public function __destruct() {}

    /**
     * Local authentication view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return ResponseInterface
     */
    public function index(Request $request, Response $response) : Response
    {
        $errors = $this->session->get('errors');

        $twig_data = [
            'page' => [
                'title' => 'Sign in - RSMS',
                'context' => 'Security'
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/security/login.html.twig', $twig_data);
    }

    public function authUser(Request $request, Response $response) : Response
    {
        $fields = $request->getParsedBody();

        $auth = [
            'email' => $fields['email'],
            'password' => $fields['password']
        ];

        $rules = [
            'required' => ['email', 'password'],
            'email' => 'email'
        ];

        $v = new Validator($auth);

        $v->rules($rules);

        if($this->session->exists('errors'))
        {
            $this->session->delete('errors');
        }

        if($v->validate() && $this->auth->authenticate($auth['email'], $auth['password']))
        {
            $user = $this->users->getAccountByEmail($auth['email']);

            $this->session->store('user', [
                'uuid' => $user->getUuid()->toString(),
                'info' => [
                    'email' => $user->getEmail(),
                    'first_name' => $user->getFirstName(),
                    'last_name' => $user->getLastName()
                ]
            ]);

            return $response->withHeader('Location', BASE_URL . '/workshop/dashboard')
                            ->withStatus(302);
        }
        else
        {
            $this->session->store('errors', $v->errors());

            return $response->withHeader('Location', BASE_URL)
                            ->withStatus(302);
        }
    }

    public function logout(Request $request, Response $response) : Response
    {
        $this->auth->deauthenticate();

        return $response->withHeader('Location', '/')
                        ->withStatus(302);
    }

    private function addTwigGlobals()
    {
        $this->twig->getEnvironment()->addGlobal('globals', [
            'base_url' => BASE_URL,
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'htmx_url' => HTMX_URL
        ]);
    }
}