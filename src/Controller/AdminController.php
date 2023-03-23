<?php

/**
 * Administrator functions controller.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 06/03/23
 */

declare(strict_types = 1);

namespace App\Controller;

use App\Domain\User;
use Slim\Views\Twig;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Interface\SessionInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class AdminController
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

    public function viewUsers(Request $request, Response $response): Response
    {
        if(!$this->verifyAdminStatus()) {
            return $response->withHeader('Location', BASE_URL)
                            ->withStatus(302);
        }

        $data = [
            'page' => [
                'title' => 'Users - RSMS',
                'context' => [
                    'name' => 'user',
                    'Name' => 'User'
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/list_view.html.twig', $data);
    }

    public function viewUser(Request $request, Response $response, array $args): Response
    {
        if(!$this->verifyAdminStatus()) {
            return $response->withHeader('Location', BASE_URL)
                            ->withStatus(302);
        }

        $userId = $args['id'];
        $user = $this->users->getAccountByUuid($userId);
        $userDisplayName = $user->getFirstName() . ' ' . $user->getLastName();

        $data = [
            'sidebar_required' => true,
            'page' => [
                'title' => $userDisplayName . ' - RSMS',
                'context' => [
                    'name' => 'user',
                    'Name' => 'User'
                ],
                'record' => [
                    'id' => $userId,
                    'display_name' => $userDisplayName
                ]
            ]
        ];

        return $this->twig->render($response, '/workshop/single_view.html.twig', $data);
    }

    public function viewSettings(Request $request, Response $response): Response
    {
        $data = [

        ];

        return $this->twig->render($response, '/admin/settings_view.html.twig', $data);
    }

    private function verifyAdminStatus(): bool
    {
        $user = $this->users->getAccountByUuid($this->session->get('user_uuid'));
        $group = $user->getGroup();

        if ($group->getPrivLevel() == 0) {
            return true;
        }
        else {
            return false;
        }

        return false;
    }
}