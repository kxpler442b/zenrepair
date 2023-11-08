<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Domain\Service\AuthenticatorService;
use App\Renderer\TwigRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewTfaLoginAction
{
    private AuthenticatorService $authService;
    private SessionInterface $session;
    private TwigRenderer $renderer;

    public function __construct(AuthenticatorService $authService, SessionInterface $session, TwigRenderer $renderer)
    {
        $this->authService = $authService;
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        var_dump($this->session->get('zenrepair_user'));

        return $this->renderer->template(
            $response,
            '/auth/login_tfa.twig',
            []
        );
    }
}