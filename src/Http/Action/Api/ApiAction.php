<?php

declare(strict_types = 1);

namespace App\Http\Action\Api;

use Psr\Log\LoggerInterface;
use App\Renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class ApiAction
{
    protected JsonRenderer $renderer;
    protected LoggerInterface $logger;

    public function __construct(
        JsonRenderer $renderer,
        LoggerInterface $logger
    ) {
        $this->renderer = $renderer;
        $this->logger = $logger;
    }

    abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}