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
use App\Service\LocalAuthService;
use App\Service\LocalAccountService;
use App\Interface\LocalAuthInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class SecurityController
{
    private readonly LocalAuthService $auth;
    private readonly Twig $twig;

    private readonly LocalAccountService $accountProvider;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get(LocalAuthInterface::class);
        $this->accountProvider = $container->get(LocalAccountProviderInterface::class);
        $this->twig = $container->get(Twig::class);

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
        $twig_data = [
            'page' => [
                'title' => 'Sign in - RSMS',
                'context' => 'Security'
            ]
        ];

        return $this->twig->render($response, '/security/layout.html.twig', $twig_data);
    }

    public function authUser(Request $request, Response $response) : Response
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->auth->attemptAuth($email, $password))
        {
            return $response->withHeader('Location', '/view/dashboard')
                            ->withStatus(302);
        }
        else
        {
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