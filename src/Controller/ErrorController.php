<?php

/**
 * Make errors great again!
 * 
 * @author Benjamin Moss <p2595849@dmu.ac.uk>
 * 
 * Date: 25/03/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;

class ErrorController
{
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function clearAll(Request $request, Response $response): Response
    {
        if($this->session->exists('errors')) {
            $this->session->delete('errors');
        }

        return $response->withStatus(200);
    }

    public function notFoundError(Request $request, Response $response): Response
    {
        return $this->twig->render($response, '/errors/404.html.twig');
    }
}