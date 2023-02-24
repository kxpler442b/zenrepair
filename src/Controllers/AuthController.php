<?php

/**
 * Authentication Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Views\Twig;
use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class AuthController
{
    private readonly AuthInterface $auth;
    private readonly UserProviderInterface $userProvider;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->auth = $container->get(AuthInterface::class);
        $this->userProvider = $container->get(UserProviderInterface::class);
        $this->twig = $container->get(Twig::class);
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
    public function index(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'title' => 'Log In - RSMS'
        ];

        return $this->twig->render($response, 'auth_view.twig', $twig_data);
    }

    public function authUser(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->auth->attemptAuth($email, $password))
        {
            return $response->withHeader('Location', '/dashboard')
                            ->withStatus(302);
        }
        else
        {
            return $response->withHeader('Location', '/')
                            ->withStatus(302);
        }
    }

    public function logout(RequestInterface $request, ResponseInterface $response) : ResponseInterface
    {
        $this->auth->deauth();

        return $response->withHeader('Location', '/')
                        ->withStatus(302);
    }
}