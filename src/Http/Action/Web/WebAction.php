<?php

declare(strict_types = 1);

namespace App\Http\Action\Web;

use Psr\Log\LoggerInterface;
use App\Renderer\TwigRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * WebAction
 */
abstract class WebAction
{
    protected TwigRenderer $renderer;
    protected LoggerInterface $logger;

    public function __construct(
        TwigRenderer $renderer,
        LoggerInterface $logger
    ) {
        $this->renderer = $renderer;
        $this->logger = $logger;
    }

    abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface;
}