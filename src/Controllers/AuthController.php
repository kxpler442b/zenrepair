<?php

/**
 * Authentication Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use App\Contracts\AuthInterface;
use App\Services\LocalAuthService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class AuthController
{
    private readonly ContainerInterface $container;
    private readonly LocalAuthService $authService;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->authService = $container->get(AuthInterface::class);
        $this->twig = $container->get(Twig::class);
    }

    public function __destruct() {}

    public function index(Request $request, Response $response) : Response
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'title' => 'Log In - RSMS'
        ];

        return $this->twig->render($response, 'auth_view.twig', $twig_data);
    }

    public function authUser(Request $request, Response $response) : Response
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($this->authService->authUserByPassword($email, $password))
        {
            return $response->withHeader('Location', '/tickets')
                            ->withStatus(302);
        }
        else
        {
            return $response->withHeader('Location', '/')
                            ->withStatus(302);
        }
    }
}