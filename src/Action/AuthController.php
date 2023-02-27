<?php

/**
 * Authentication Controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Action;

use App\Interface\LocalAccountProviderInterface;
use App\Interface\LocalAuthInterface;
use App\Service\LocalAccountService;
use Slim\Views\Twig;
use App\Service\LocalAuthService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface as Response;

use function PHPSTORM_META\map;

class AuthController
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
    public function index(RequestInterface $request, Response $response) : Response
    {
        $twig_data = [
            'css_url' => CSS_URL,
            'assets_url' => ASSETS_URL,
            'title' => 'Log In - RSMS'
        ];

        return $this->twig->render($response, 'auth_view.twig', $twig_data);
    }

    public function authUser(RequestInterface $request, Response $response) : Response
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

    public function logout(RequestInterface $request, Response $response) : Response
    {
        $this->auth->deauth();

        return $response->withHeader('Location', '/')
                        ->withStatus(302);
    }
}