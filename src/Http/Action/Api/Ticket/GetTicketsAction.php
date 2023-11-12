<?php

declare(strict_types = 1);

namespace App\Http\Action\Api\Ticket;

use Psr\Log\LoggerInterface;
use App\Renderer\JsonRenderer;
use App\Http\Action\Api\ApiAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetTicketsAction extends ApiAction
{
    public function __construct(
        JsonRenderer $renderer,
        LoggerInterface $logger
    ) {
        parent::__construct($renderer, $logger);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = [
            'test' => 'test'
        ];

        return $this->renderer->json(
            $response,
            $data
        );
    }
}