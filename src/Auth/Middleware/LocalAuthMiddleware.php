<?php

/**
 * Authentication middleware.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Auth\Middleware;

use Slim\App;
use Auth0\SDK\Auth0;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Auth\Contract\AuthProviderContract;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class LocalAuthMiddleware implements MiddlewareInterface
{
    private readonly AuthProviderContract $auth;
    private readonly ResponseFactoryInterface $responseFactory;

    /**
     * Constructor method.
     *
     * @param Auth0 $auth0
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(AuthProviderContract $auth, ResponseFactoryInterface $responseFactory)
    {
        $this->auth = $auth;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Returns a new AuthMiddleware class.
     *
     * @param App $app
     * @param ContainerInterface $c
     * @return void
     */
    public static function create(App $app, ContainerInterface $c)
    {
        $auth = $c->get(AuthProviderContract::class);

        return new self($auth, $app->getResponseFactory());
    }

    /**
     * Checks if there is an authenticated session present.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * 
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if(!$this->auth->verify())
        {
            return $this->responseFactory->createResponse(302)->withHeader('Location', BASE_URL);
        }

        return $handler->handle($request);
    }
}