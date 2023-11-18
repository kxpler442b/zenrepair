<?php

declare(strict_types = 1);

namespace App\Http\Action\Web\Device;

use Psr\Log\LoggerInterface;
use App\Renderer\TwigRenderer;
use App\Http\Action\Web\WebAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ViewDevicesAction extends WebAction
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
                'group' => 'devices'
            ]
        ];

        return $this->renderer->template(
            $response,
            '/pages/devices/devices_table.twig',
            $data
        );
    }
}