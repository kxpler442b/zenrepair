<?php

/**
 * User account actions controller.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 17/02/23
 */

declare(strict_types = 1);

namespace App\Controller;

use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class UserController
{  
    private readonly LocalAccountProviderInterface $users;

    private readonly SessionInterface $session;
    private readonly Twig $twig;

    public function __construct(ContainerInterface $c)
    {
        $this->users = $c->get(LocalAccountProviderInterface::class);

        $this->session = $c->get(SessionInterface::class);
        $this->twig = $c->get(Twig::class);
    }

    public function getUserRecord(Request $request, Response $response, array $args): Response
    {
        $userId = $args['id'];
        $user = $this->users->getAccountByUuid($userId);
        $userDisplayName = $user->getFirstName() . ' ' . $user->getLastName();

        $twig_data = [
            'page' => [
                'record' => [
                    'display_name' => $userDisplayName
                ],
            ],
            'user' => [
                'id' => $user->getUuid()->toString(),
                'details' => [
                    'First Name' => $user->getFirstName(),
                    'Last Name' => $user->getLastName(),
                    'Email Address' => $user->getEmail(),
                    'Group' => $user->getGroup()->getName()
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/fragments/user.html', $twig_data);
    }

    public function getUserRecords(Request $request, Response $response): Response
    {
        $data = [];
        $usersArray = $this->users->getAccounts();

        foreach($usersArray as &$user)
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

        return $this->twig->render($response, '/workshop/fragments/table.html.twig', $twig_data);
    }
}