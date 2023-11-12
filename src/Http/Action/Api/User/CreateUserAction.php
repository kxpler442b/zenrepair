<?php

declare(strict_types = 1);

namespace App\Http\Action\Api\User;

use Psr\Log\LoggerInterface;
use App\Renderer\JsonRenderer;
use App\Http\Action\Api\ApiAction;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\AuthenticatorService;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;

final class CreateUserAction extends ApiAction
{
    private AuthenticatorService $auth;

    public function __construct(
        AuthenticatorService $auth,
        JsonRenderer $renderer,
        LoggerInterface $logger
    ) {
        $this->auth = $auth;

        parent::__construct($renderer, $logger);
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