<?php

declare(strict_types = 1);

namespace App\Http\Action\Auth;

use Psr\Log\LoggerInterface;
use App\Domain\Enum\AuthEnum;
use App\Domain\Enum\InputGuardEnum;
use App\Renderer\RedirectRenderer;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\AuthenticatorService;
use App\Domain\Service\InputGuardService;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;
use Fig\Http\Message\StatusCodeInterface;

final class DoLoginAction
{
    private AuthenticatorService $authenticator;
    private InputGuardService $inputGuard;
    private RedirectRenderer $renderer;
    private LoggerInterface $logger;
    
    public function __construct(
        AuthenticatorService $authenticator,
        InputGuardService $inputGuard,
        RedirectRenderer $renderer,
        LoggerInterface $logger
    ) {
        $this->authenticator = $authenticator;
        $this->inputGuard = $inputGuard;
        $this->renderer = $renderer;
        $this->logger = $logger;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = $this->inputGuard->process(
            $request->getParsedBody(),
            'userLogin'
        );

        if($result == InputGuardEnum::FAILED_ERROR) {
            return $this->renderer->hxRedirect(
                $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED),
                '/login'
            );
        }

        $data = $this->inputGuard->getOutput();

        $credentials = new UserCredentialsObject(
            $data['username'],
            $data['password']
        );

        $result = $this->authenticator->login($credentials);

        if($result == AuthEnum::AUTH_SUCCESS) {
            return $this->renderer->hxRedirect(
                $response->withStatus(StatusCodeInterface::STATUS_FOUND),
                '/web/dashboard'
            );
        } elseif($result == AuthEnum::AUTH_TWOFACTOR) {
            return $this->renderer->hxRedirect(
                $response->withStatus(StatusCodeInterface::STATUS_FOUND),
                '/twostep'
            );
        } elseif($result == AuthEnum::AUTH_FAILED) {
            return $this->renderer->hxRedirect(
                $response->withStatus(StatusCodeInterface::STATUS_UNAUTHORIZED),
                '/login'
            );
        }
    }
}