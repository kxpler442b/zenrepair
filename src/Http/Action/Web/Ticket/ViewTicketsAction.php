<?php

declare(strict_types = 1);

namespace App\Http\Action\Web\Ticket;

use Psr\Log\LoggerInterface;
use App\Renderer\TwigRenderer;
use App\Http\Action\Web\WebAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewTicketsAction extends WebAction
{
    public function __construct(
        TwigRenderer $renderer,
        LoggerInterface $logger
    ) {
        parent::__construct($renderer, $logger);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            'page' => [
                'group' => 'tickets'
            ]
        ];

        return $this->renderer->template(
            $response,
            '/pages/tickets/tickets_table.twig',
            $data
        );
    }
}