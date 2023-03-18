<?php

/**
 * Error handling middleware.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 11/03/23
 */

declare(strict_types = 1);

namespace App\Middleware;

use Slim\App;
use Throwable;
use Slim\Views\Twig;
use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

class ErrorMiddleware
{
    private readonly ResponseFactoryInterface $responseFactory;
    private readonly Twig $twig;
    private readonly array $options;

    public function __construct(ResponseFactoryInterface $response, Twig $twig, array $options)
    {
        $this->responseFactory = $response;
        $this->twig = $twig;
        $this->options = $options;
    }

    public static function create(App $app, array $options = ['displayErrorDetails' => false, 'logErrors' => true, 'logErrorDetails' => false]): self
    {
        $c = $app->getContainer();

        return new self($app->getResponseFactory(ResponseFactoryInterface::class), $c->get(Twig::class), $options);
    }

    public function process(Throwable $exception): Response
    {
        $exception->getMessage();

        $response = $this->responseFactory->createResponse();

        return $this->twig->render($response, '/exception/error.html');
    }
}