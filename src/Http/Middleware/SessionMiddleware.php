<?php

/**
 * Session middleware class.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * 
 * Date: 15/02/23
 */

declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Interface\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    private readonly SessionInterface $session;

    public function __construct(SessionInterface $session) {
        $this->session = $session;
    }

    public static function create(SessionInterface $session)
    {
        return new self(
            $session
        );
    }

    /**
     * Session Middlware Process
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * 
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $this->session->start();

        $response = $handler->handle($request);

        $this->session->save();

        return $response;
    }
}