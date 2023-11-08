<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Domain\Service\AuthenticatorService;
use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DoLogoutAction
{
    private AuthenticatorService $authService;
    private RedirectRenderer $renderer;

    public function __construct(AuthenticatorService $authService, RedirectRenderer $renderer)
    {
        $this->authService = $authService;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $this->authService->logout();

        return $this->renderer->redirect(
            $response,
            '/auth/login'
        );
    }
}