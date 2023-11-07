<?php

declare(strict_types = 1);

namespace App\Http\Action\User;

use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\AuthenticatorService;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;

final class CreateUserAction
{
    private AuthenticatorService $auth;
    private JsonRenderer $renderer;

    public function __construct(AuthenticatorService $auth, JsonRenderer $renderer)
    {
        $this->auth = $auth;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $credentials = new UserCredentialsObject(
            'benjamin',
            'hello',
            'benmoss2002@fastmail.co.uk',
            'Benjamin',
            'Moss'
        );

        $this->auth->createUser($credentials);

        return $this->renderer->json(
            $response,
            ['check']
        );
    }
}