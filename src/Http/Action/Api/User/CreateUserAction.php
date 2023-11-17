<?php

declare(strict_types = 1);

namespace App\Http\Action\Api\User;

use Psr\Log\LoggerInterface;
use App\Renderer\JsonRenderer;
use App\Http\Action\Api\ApiAction;
use App\Domain\Enum\InputGuardEnum;
use App\Domain\Service\UserService;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\InputGuardService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;

final class CreateUserAction extends ApiAction
{
    private UserService $users;
    private InputGuardService $inputGuard;

    public function __construct(
        UserService $users,
        InputGuardService $inputGuard,
        JsonRenderer $renderer,
        LoggerInterface $logger
    ) {
        $this->users = $users;
        $this->inputGuard = $inputGuard;

        parent::__construct($renderer, $logger);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $result = $this->inputGuard->process(
            $request->getParsedBody(),
            'accountCreation'
        );

        if($result == InputGuardEnum::SUCCESS) {
            $data = $this->inputGuard->getOutput();

            $credentials = new UserCredentialsObject(
                $data['create_form_username'],
                $data['create_form_password'],
                $data['create_form_email'],
                $data['create_form_given_name'],
                $data['create_form_family_name']
            );

            $this->users->createUser($credentials);

            return $response->withStatus(StatusCodeInterface::STATUS_CREATED);
        }

        $response->getBody()->write(json_encode($this->inputGuard->getErrors()));

        return $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}