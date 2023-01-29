<?php

/**
 * Base controller class.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use App\Config;
use App\Services\AuthService;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

class AuthController
{
    protected ContainerInterface $container;
    protected AuthService $authService;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->authService = new AuthService($this, $container->get(Config::class));
    }

    public function __destruct() {}

    public function getContainer() : ContainerInterface
    {
        return $this->container;
    }

    public function index(Request $request, Response $response) : Response
    {
        return $response
            ->withHeader('Location', '/login')
            ->withStatus(302);
    }

    public function redirect(Request $request, Response $response) : Response
    {
        $_SESSION['state'] = bin2hex(random_bytes(5));
        $url = $this->authService->buildAuthorizeUrl($_SESSION['state']);

        var_dump($url);

        return $response
            ->withHeader('Location', $url)
            ->withStatus(302);
    }

    public function callback(Request $request, Response $response) : Response
    {
        $result = $this->authService->authorizeUser();
        
        if (isset($result['error']))
        {
            // $this->logger->error($result['error']);

            return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
        }
        else 
        {
            return $response
                ->withHeader('Location', '/dashboard')
                ->withStatus(302);
        }
    }

    public function logout(Request $request, Response $response) : Response
    {
        session_destroy();

        return $response
                ->withHeader('Location', '/login')
                ->withStatus(302);
    }
}