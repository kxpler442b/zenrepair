<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Domain\Enum\AuthEnum;
use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\AuthenticatorService;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;

final class DoLoginAction
{
    private AuthenticatorService $authenticator;
    private RedirectRenderer $renderer;
    
    public function __construct(AuthenticatorService $authenticator, RedirectRenderer $renderer)
    {
        $this->authenticator = $authenticator;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $formData = $request->getParsedBody();

        $credentials = new UserCredentialsObject(
            $formData['username'],
            $formData['password']
        );

        $result = $this->authenticator->login($credentials);

        if($result == AuthEnum::AUTH_SUCCESS) {
            return $this->renderer->redirect(
                $response,
                '/dashboard'
            );
        } elseif($result == AuthEnum::AUTH_FAILED) {
            return $this->renderer->redirect(
                $response,
                '/auth/login'
            );
        }
    }
}