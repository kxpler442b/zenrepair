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

        $data = [
            'record' => [
                'display_name' => $user->getFirstName().' '.$user->getLastName(),
                'table' => [
                    'First Name' => $user->getFirstName(),
                    'Last Name' => $user->getLastName(),
                    'Email' => $user->getEmail(),
                    'Group' => $user->getGroup()->getName(),
                    'Created' => $user->getCreated()->format('d-m-Y'),
                    'Last Updated' => $user->getUpdated()->format('H:i:s, d-m-Y')
                ]
            ]
        ];

        return $this->twig->render($response, '/read/user.html', $data);
    }

    public function getUserRecords(Request $request, Response $response): Response
    {
        $table = [];
        $users = $this->users->getAccounts();

        foreach($users as &$user)
        {
            $displayName = $user->getFirstName().' '.$user->getLastName();

            $table[$user->getUuid()->toString()] = array(
                [
                    'link' => BASE_URL . '/view/user/' . $user->getUuid()->toString(),
                    'data' => $displayName
                ],
                'email' => $user->getEmail(),
                'group' => $user->getGroup()->getName(),
                'created' => $user->getCreated()->format('d-m-Y'),
                'updated' => $user->getUpdated()->format('d-m-Y')
            );

            $data = [
                'table' => [
                    'cols' => [
                        'primary' => 'Name',
                        'headers' => ['Email Address', 'Group', 'Created', 'Last Updated']
                    ],
                    'rows' => $table
                ]
            ];

            return $this->twig->render($response, '/read/table.html.twig', $data);
        }
    }
}