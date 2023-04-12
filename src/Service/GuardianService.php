<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Service;

use App\Support\Guardian;
use App\Interface\SessionInterface;
use App\Interface\GuardianInterface;
use Psr\Container\ContainerInterface;
use App\Interface\LocalAccountProviderInterface;

class GuardianService implements GuardianInterface
{
    protected Guardian $guardian;

    private readonly LocalAccountProviderInterface $users;
    private readonly SessionInterface $session;

    public function __construct(ContainerInterface $c, array $keys)
    {
        $this->users = $c->get(LocalAccountProviderInterface::class);
        $this->session = $c->get(SessionInterface::class);

        $this->guardian = new Guardian($keys);
    }

    public function authenticate(string $email, string $password): bool
    {
        $user = $this->users->getAccountByEmail($email);

        if($user != null)
        {
            $token = $this->guardian->authenticate($user, $password);
        }
        else
        {
            return false;
        }

        if($token != null)
        {
            if($this->session->exists('jwt'))
            {
                $this->session->delete('jwt');
            }

            $this->session->store('jwt', $token);

            return true;
        }
        else
        {
            return false;
        }
    }

    public function verify(): bool
    {
        $jwt = $this->session->get('jwt');

        if($jwt != null && $this->guardian->verify($jwt))
        {
            return true;
        }

        return false;
    }

    public function deauthenticate(): void
    {
        if($this->session->exists('jwt'))
        {
            $this->session->delete('jwt');
        }
    }
}