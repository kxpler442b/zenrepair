<?php

declare(strict_types = 1);

namespace App\Http\Action\Api\Ticket;

use Psr\Log\LoggerInterface;
use App\Renderer\JsonRenderer;
use App\Http\Action\Api\ApiAction;
use App\Domain\Enum\InputGuardEnum;
use App\Domain\Service\TicketService;
use App\Domain\XferObject\TicketObject;
use Psr\Http\Message\ResponseInterface;
use App\Domain\Service\SanitizerService;
use App\Domain\Service\InputGuardService;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Domain\XferObject\UserCredentialsObject;
use Exception;

final class CreateTicketAction extends ApiAction
{
    private TicketService $tickets;
    private InputGuardService $inputGuard;
    private SanitizerService $sanitizer;

    public function __construct(
        TicketService $tickets,
        InputGuardService $inputGuard,
        JsonRenderer $renderer,
        LoggerInterface $logger,
        SanitizerService $sanitizer
    ) {
        $this->tickets = $tickets;
        $this->inputGuard = $inputGuard;
        $this->sanitizer = $sanitizer;

        parent::__construct($renderer, $logger);
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        try {
            $data['create_form_title'] = $this->sanitizer->sanitizeString($data['create_form_title']);
        } catch (Exception $e) {
            //change in production
            $this->logger->debug($e . 'sanitization failed');
            return $response->withStatus(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }

        $result = $this->inputGuard->process(
            $data,
            'ticketCreation'
        );

        if($result == InputGuardEnum::SUCCESS) {
            $data = $this->inputGuard->getOutput();

            $ticketObj = new TicketObject(
                $data['create_form_title'],
                (int) $data['create_form_status']
            );

            $this->tickets->createTicket($ticketObj);

            return $response->withStatus(StatusCodeInterface::STATUS_CREATED);
        }

        $response->getBody()->write(json_encode($this->inputGuard->getErrors()));

        return $response->withStatus(StatusCodeInterface::STATUS_BAD_REQUEST);
    }
}