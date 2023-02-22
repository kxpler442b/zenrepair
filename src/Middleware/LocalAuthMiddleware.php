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

use App\Contracts\SessionInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LocalAuthMiddleware implements MiddlewareInterface
{
    //private readonly ResponseFactoryInterface $responseFactory;
    //private readonly SessionInterface $session;

    public function __construct(ResponseFactoryInterface $responseFactory, SessionInterface $session)
    {
        $this->responseFactory = $responseFactory;
        $this->session = $session;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        if($this->session->exists['user_id'])
        {
            return $handler->handle($request);
        }

        return $this->responseFactory->createResponse(302)
                                    ->withHeader('Location', '/');
    }
}