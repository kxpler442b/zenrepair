<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use App\Renderer\TwigRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewLoginAction
{
    private TwigRenderer $renderer;

    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            'page' => [
                'title' => 'Login - zenRepair'
            ]
        ];

        return $this->renderer->template(
            $response,
            '/pages/auth/auth_password.twig',
            $data
        );
    }
}