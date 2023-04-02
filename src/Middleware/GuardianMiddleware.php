<?php

declare(strict_types = 1);

namespace App\Middleware;

use Slim\App;
use Slim\Views\Twig;
use App\Interface\SessionInterface;
use App\Interface\GuardianInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class GuardianMiddleware implements MiddlewareInterface
{
    private readonly ResponseFactoryInterface $responseFactory;
    private readonly GuardianInterface $auth;
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ResponseFactoryInterface $responseFactory, GuardianInterface $auth, SessionInterface $session, Twig $twig)
    {
        $this->responseFactory = $responseFactory;
        $this->auth = $auth;
        $this->session = $session;
        $this->twig = $twig;
    }

    public static function create(App $app)
    {
        $c = $app->getContainer();

        return new self(
            $app->getResponseFactory(ResponseFactoryInterface::class),

            $c->get(GuardianInterface::class),
            $c->get(SessionInterface::class),
            $c->get(Twig::class)
        );
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if($this->auth->verify())
        {
            $user = $this->session->get('user');

            $this->twig->getEnvironment()->addGlobal('user', [
                'uuid' => $user['uuid'],
                'info' => [
                    'email' => $user['info']['email'],
                    'first_name' => $user['info']['first_name'],
                    'last_name' => $user['info']['last_name']
                ]
            ]);

            return $handler->handle($request);
        }

        return $this->responseFactory->createResponse(302)->withHeader('Location', '/login');
    }
}