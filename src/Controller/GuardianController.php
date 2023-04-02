<?php

/**
 * Guardian (auth) Controller.
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
use App\Interface\SessionInterface;
use App\Interface\GuardianInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class GuardianController
{
    private readonly GuardianInterface $guardian;
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
        $this->guardian = $c->get(GuardianInterface::class);
        $this->users = $c->get(LocalAccountProviderInterface::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
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
    public function getUserLoginView(Request $request, Response $response) : Response
    {
        $errors = $this->session->get('errors');

        $twig_data = [
            'page' => [
                'title' => 'Sign in - RSMS',
                'context' => 'Security'
            ],
            'is_login' => true,
            'errors' => $errors
        ];

        return $this->twig->render($response, '/guardian/login.html', $twig_data);
    }

    public function doSignInUser(Request $request, Response $response) : Response
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

        if($v->validate() && $this->guardian->authenticate($auth['email'], $auth['password']))
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

            return $response->withHeader('HX-Location', BASE_URL . '/workshop/dashboard')
                            ->withStatus(302);
        }
        else
        {
            $this->session->store('errors', $v->errors());

            return $response->withHeader('HX-Location', BASE_URL . '/login')
                            ->withStatus(302);
        }
    }

    public function doSignOutUser(Request $request, Response $response) : Response
    {
        $this->guardian->deauthenticate();

        return $response->withHeader('Location', '/login')
                        ->withStatus(302);
    }
}