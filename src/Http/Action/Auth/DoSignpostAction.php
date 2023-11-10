<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Domain\Service\AuthenticatorService;
use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class DoSignpostAction
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
        if($this->authService->verify()) {
            return $this->renderer->redirect(
                $response,
                '/web/dashboard'
            );
        } else {
            return $this->renderer->redirect(
                $response,
                '/login'
            );
        }
    }
}