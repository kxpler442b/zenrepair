<?php

/**
 * Authentication middleware.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Middleware;

use Slim\App;
use Auth0\SDK\Auth0;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class AuthMiddleware implements MiddlewareInterface
{
    private readonly Auth0 $auth0;
    private readonly ResponseFactoryInterface $responseFactory;
    private ?object $session;

    /**
     * Constructor method.
     *
     * @param Auth0 $auth0
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(Auth0 $auth0, ResponseFactoryInterface $responseFactory)
    {
        $this->auth0 = $auth0;
        $this->responseFactory = $responseFactory;
        $this->session = null;
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
        $auth0 = $c->get(Auth0::class);

        return new self($auth0, $app->getResponseFactory());
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
        $this->session = $this->auth0->getCredentials();

        if($this->session === null)
        {
            return $this->responseFactory->createResponse(302)
                                        ->withHeader('Location', BASE_URL . '/login'); 
        }

        return $handler->handle($request);
    }
}