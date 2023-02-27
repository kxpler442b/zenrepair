<?php

/**
 * Local authentication middleware.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/02/23
 */

declare(strict_types = 1);

namespace App\Middleware;

use Slim\App;
use Slim\Views\Twig;
use App\Interface\LocalAuthInterface;
use App\Interface\SessionInterface;
use App\Service\LocalAuthService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class LocalAuthMiddleware implements MiddlewareInterface
{
    private readonly ResponseFactoryInterface $responseFactory;
    private readonly LocalAuthService $auth;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ResponseFactoryInterface $responseFactory, LocalAuthInterface $auth, SessionInterface $session, Twig $twig)
    {
        $this->responseFactory = $responseFactory;
        $this->auth = $auth;
        $this->twig = $twig;
        $this->session = $session;
    }

    public static function create(App $app, ContainerInterface $container)
    {
        return new self(
            $app->getResponseFactory(ResponseFactoryInterface::class),
            $container->get(AuthInterface::class),
            $container->get(SessionInterface::class),
            $container->get(Twig::class)
        );
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $user = $this->auth->verify();

        if($user !== null)
        {
            $this->twig->getEnvironment()->addGlobal('user_info', [
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail()
            ]);

            return $handler->handle($request);
        }

        return $this->responseFactory->createResponse(302)->withHeader('Location', '/');
    }
}