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
use App\Service\LocalAuthService;
use App\Interface\LocalAuthInterface;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use DateTime;

class SecurityController
{
    private readonly LocalAuthService $auth;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $c)
    {
        $this->auth = $c->get(LocalAuthInterface::class);

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
            'errors' => $errors,
            'error_timestamp' => $this->session->get('error_timestamp')
        ];

        return $this->twig->render($response, '/security/login.html.twig', $twig_data);
    }

    public function authUser(Request $request, Response $response) : Response
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $rules = [
            'required' => ['email', 'password'],
            'email' => 'email'
        ];

        $v = new Validator([
            'email' => $email,
            'password' => $password
        ]);

        $v->rules($rules);

        $datetime = new DateTime('now');

        if($this->session->exists('errors')) {
            $this->session->delete('errors');
            $this->session->delete('error_timestamp');
        }

        if($v->validate()) {
            if ($this->auth->attemptAuth($email, $password)) {
                return $response->withHeader('Location', '/workshop/dashboard')
                                ->withStatus(302);
            }
            else {
                $this->session->store('errors', $v->errors());
                $this->session->store('error_timestamp', $datetime->format('H:i:s'));

                return $response->withHeader('Location', '/')
                                ->withStatus(302);
            }
        }
        else {
            $this->session->store('errors', $v->errors());
            $this->session->store('error_timestamp', $datetime->format('H:i:s'));

            return $response->withHeader('Location', '/')
                            ->withStatus(302);
        }
    }

    public function logout(Request $request, Response $response) : Response
    {
        $this->auth->deauth();

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