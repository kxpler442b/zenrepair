<?php

declare(strict_types = 1);

namespace App\Auth;

use App\Auth\Interface\AuthInterface;
use App\Auth\Interface\LocalUserRepositoryInterface;
use App\Support\Settings\SettingsInterface;
use Psr\Container\ContainerInterface;

class Auth implements AuthInterface
{
    private LocalUserRepositoryInterface $users;
    private array $options;

    public function __construct(ContainerInterface $c, array $options)
    {
        $this->users = $c->get(LocalUserRepositoryInterface::class);
        $this->options = $options;
    }

    public function login(array $credentials)
    {

    }

    public function verify(array $credentials)
    {

    }

    public function logout()
    {

    }

    public function createUser(array $credentials)
    {
        $hashedPassword = password_hash($credentials['password'], $this->options['crypto']['algo'], $this->options['crypto']['options']);

        $credentials['password'] = $hashedPassword;

        $localUser = $this->users->getNewUser($credentials);
        $this->users->persistUser($localUser);
    }
}