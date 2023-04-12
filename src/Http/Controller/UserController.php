<?php

/**
 * Users controller.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Http\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Service\UserService;
use Psr\Container\ContainerInterface;

class UserController
{
    private readonly UserService $users;
    private readonly Twig $twig;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->users = $c->get(UserService::class);
        $this->twig = $c->get(Twig::class);
    }

    /**
     * Returns a list of registered Users in a table view.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function index(Request $request, Response $response): Response
    {
        $data = [];
        $users = $this->users->getAll();

        foreach($users as &$user)
        {
            $data[$user->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/admin/user/' . $user->getUuid()->toString(),
                    'text' => $user->getFirstName().' '.$user->getLastName()
                ],
                'email' => $user->getEmail(),
                'group' => $user->getGroup()->getName(),
                'created' => $user->getCreated()->format('d-m-Y'),
                'last_updated' => $user->getUpdated()->format('d-m-Y H:i:s')
            );
        };

        $twig_data = [
            'page' => [
                'title' => 'Users',
                'context' => [
                    'name' => 'user',
                    'Name' => 'User'
                ]
            ],
            'table' => [
                'cols' => [
                    'headers' => ['Name', 'Email Address', 'Group', 'Created', 'Last Updated']
                ],
                'rows' => $data
            ]
        ];

        return $this->twig->render($response, '/app/fragments/table.html.twig', $twig_data);
    }

    /**
     * Returns a HTML form for creating a new User.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function new(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Users'
            ]
        ];

        return $this->twig->render($response, '/app/forms/user_create.html.twig');
    }

    /**
     * Returns a HTML fragment for a single User.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function show(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Users'
            ]
        ];

        return $this->twig->render($response, '/app/fragments/user_view.html.twig');
    }

    /**
     * Returns a HTML form for editing a User.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return Response
     */
    public function edit(Request $request, Response $response): Response
    {
        $twig_data = [
            'page' => [
                'title' => 'Users'
            ]
        ];

        return $this->twig->render($response, '/app/forms/user_edit.html.twig');
    }

    /**
     * Creates a new User account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function create(Request $request, Response $response)
    {
        
    }
    
    /**
     * Updates the credentials of a User account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function update(Request $request, Response $response)
    {
        
    }
    
    /**
     * Deletes the specified User account.
     *
     * @param Request $request
     * @param Response $response
     * 
     * @return void
     */
    public function delete(Request $request, Response $response)
    {
        
    }
}