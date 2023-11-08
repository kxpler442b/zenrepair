<?php

declare(strict_types = 1);

namespace App\Http\Action\Dashboard;

use App\Renderer\TwigRenderer;
use Odan\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewDashboardAction
{
    private SessionInterface $session;
    private TwigRenderer $renderer;

    public function __construct(SessionInterface $session, TwigRenderer $renderer)
    {
        $this->session = $session;
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $encodedData = $this->sessionDataEncoder([
            'zenrepair_session_auth' => '0000',
            'zenrepair_user' => '0000'
        ]);

        var_dump($encodedData);

        return $this->renderer->template(
            $response,
            '/dashboard/dashboard.twig',
            [
                'zenrepair_session_auth' => $this->session->get('zenrepair_session_auth'),
                'zenrepair_user' => $this->session->get('zenrepair_user')
            ]
        );
    }

    public function sessionDataEncoder(array $data): array
    {
        $encodedData = [];

        foreach($data as $key => $value) {
            $encodedData[$key] = base64_encode($value);
        }

        return $encodedData;
    }
}