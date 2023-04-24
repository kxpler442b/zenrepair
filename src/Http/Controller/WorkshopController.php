<?php

/**
 * Workshop controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use App\Interface\SessionInterface;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;
use Valitron\Validator;

class WorkshopController
{
    private readonly Twig $twig;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     */
    public function __construct(ContainerInterface $c)
    {
        $this->twig = $c->get(Twig::class);
        $this->session = $c->get(SessionInterface::class);
    }

    /**
     * Returns the Workshop dashboard view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function dashboard(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Dashboard',
                'context' => [
                    'name' => 'dashboard',
                    'Name' => 'Dashboard'
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/dashboard/dashboard_view.html.twig', $twig_data);
    }

    /**
     * Returns a list view for the given context if it is found in the whitelist.
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * 
     * @return Response
     */
    public function listView(Request $request, Response $response, array $args): Response
    {
        $context = $args['context'];

        $whitelist = array('customers', 'tickets', 'devices');

        /**
         * Throw a 404 error if the context is not found.
         */
        if(!in_array($context, $whitelist))
        {
            return $response->withHeader('Location', BASE_URL . '/workshop/dashboard')
                            ->withStatus(404);
        }

        if($this->session->exists('errors'))
        {
            $errors = $this->session->get('errors');
        }
        else
        {
            $errors = null;
        }

        $twigData = [
            'page' => [
                'title' => ucwords($context) . ' - RSMS',
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $context]),
                    'name' => rtrim($context, 's'),
                    'Name' => ucwords(rtrim($context, 's'))
                ],
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/workshop/list/list_view.html.twig', $twigData);
    }

    public function singleView(Request $request, Response $response, array $args): Response
    {
        $context = $args['context'];
        $uuid = $args['id'];

        if(!$this->whitelist($context))
        {
            return $response->withHeader('Location', BASE_URL . '/workshop/dashboard')
                            ->withStatus(404);
        }

        if($this->session->exists('errors'))
        {
            $errors = $this->session->get('errors');
        }
        else
        {
            $errors = null;
        }

        $twigData = [
            'page' => [
                'title' => ucwords($context) . ' - RSMS',
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $context, 's']),
                    'name' => implode('', [$context, 's']),
                    'Name' => ucwords(implode('', [$context, 's']))
                ],
                'recordId' => $uuid
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/workshop/single/single_view.html.twig', $twigData);
    }

    public function createView(Request $request, Response $response, array $args): Response
    {
        $context = $args['context'];

        if(!$this->whitelist($context))
        {
            return $response->withHeader('Location', BASE_URL . '/workshop/view/dashboard')
                            ->withStatus(404);
        }

        if($this->session->exists('errors'))
        {
            $errors = $this->session->get('errors');
        }
        else
        {
            $errors = null;
        }

        $twigData = [
            'page' => [
                'title' => ucwords($context) . ' - RSMS',
                'context' => [
                    'endpoint' => implode('', [BASE_URL, '/', $context, 's']),
                    'name' => implode('', [$context, 's']),
                    'Name' => ucwords(implode('', [$context, 's']))
                ],
            ],
            'errors' => $errors
        ];

        return $this->twig->render($response, '/workshop/create/create_view.html.twig', $twigData);
    }

    private function whitelist(string $context): bool
    {
        $whitelist = array('customer', 'ticket', 'device');

        /**
         * Return True only if the context exists in the whitelist, else return False.
         */
        if(in_array($context, $whitelist))
        {
            return true;
        }

        return false;
    }
}