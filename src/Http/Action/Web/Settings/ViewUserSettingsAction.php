<?php

declare(strict_types = 1);

namespace App\Http\Action\Web\Settings;

use Psr\Log\LoggerInterface;
use App\Renderer\TwigRenderer;
use App\Http\Action\Web\WebAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ViewUserSettingsAction extends WebAction
{
    public function __construct(
        TwigRenderer $renderer,
        LoggerInterface $logger
    ) {
       parent::__construct($renderer, $logger);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $this->renderer->template(
            $response,
            '/pages/settings/user_settings.twig'
        );
    }
}