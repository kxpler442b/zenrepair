<?php

declare(strict_types = 1);

namespace App\Http\Handler;

use Throwable;
use GuzzleHttp\Psr7\Response;
use Slim\Handlers\ErrorHandler;
use App\Http\Action\ActionError;
use Slim\Exception\HttpException;
use App\Http\Action\ActionPayload;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpMethodNotAllowedException;

class HttpErrorHandler extends ErrorHandler
{
    protected function respond(): Response
    {
        $exception = $this->exception;
        $statusCode = 500;
        $error = new ActionError(
            ActionError::SERVER_ERROR,
            'An internal server error has occured. Please try again later.'
        );

        if($exception instanceof HttpException) {
            $statusCode = $exception->getCode();
            $error->setDescription($exception->getMessage());

            if($exception instanceof HttpNotFoundException) {
                $error->setType(ActionError::RESOURCE_NOT_FOUND);
            } elseif($exception instanceof HttpMethodNotAllowedException) {
                $error->setType(ActionError::NOT_ALLOWED);
            } elseif($exception instanceof HttpUnauthorizedException) {
                $error->setType(ActionError::UNAUTHENTICATED);
            } elseif($exception instanceof HttpForbiddenException) {
                $error->setType(ActionError::INSUFFICIENT_PRIVILEGES);
            } elseif($exception instanceof HttpBadRequestException) {
                $error->setType(ActionError::BAD_REQUEST);
            } elseif($exception instanceof HttpNotImplementedException) {
                $error->setType(ActionError::NOT_IMPLEMENTED);
            }
        }

        if(
            !($exception instanceof HttpException)
            && $exception instanceof Throwable
            && $this->displayErrorDetails
        ) {
            $error->setDescription($exception->getMessage());
        }

        $payload = new ActionPayload($statusCode, null, $error);
        $encodedPayload = json_encode($payload, JSON_PRETTY_PRINT);

        $response = $this->responseFactory->createResponse($statusCode);
        $response->getBody()->write($encodedPayload);

        return $response->withHeader('Content-Type', 'application/json');
    }
}