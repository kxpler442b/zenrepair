<?php

/**
 * Customer portal controller
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 24/03/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use Valitron\Validator;

class PortalController
{
    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function getLoginView(Request $request, Response $response): Response
    {
        return $this->twig->render($response, '/security/portal_login.html.twig');
    }

    public function handleLogin(Request $request, Response $response): Response
    {
        $rules = array(
            'required' => ['email_address', 'access_code']
        );

        $data = $request->getParsedBody();

        $customer = array(
            'email_address' => $data['email_address'],
            'access_code' => $data['access_code']
        );

        $v = new Validator($customer);
        $v->rules($rules);

        if($v->validate())
        {
            return $response->withHeader('HX-Location', BASE_URL . '/portal/overview')
                            ->withStatus(302);
        }
        else
        {
            return $response->withHeader('HX-Location', BASE_URL . '/portal')
                            ->withStatus(302);
        }
    }

    public function getListView(Request $request, Response $response): Response
    {
        $response->getBody()->write('portal overview');
        return $response;
    }
}