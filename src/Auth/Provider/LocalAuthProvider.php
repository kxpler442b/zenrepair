<?php

/**
 * Local authentication provider.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Auth\Provider;

use App\Auth\Contract\AuthProviderContract;
use App\Interface\SessionInterface;
use App\Service\UserService;

class LocalAuthProvider implements AuthProviderContract
{
    private readonly UserService $users;
    private readonly SessionInterface $session;

    public function __construct(UserService $userService, SessionInterface $session)
    {
        $this->users = $userService;
        $this->session = $session;
    }

    /**
     * Authenticates a user
     *
     * @param string $email
     * @param string $password
     * 
     * @return boolean
     */
    public function login(string $email, string $password): bool
    {
        if($this->session->exists('auth'))
        {
            $this->session->delete('auth');
        }

        $user = $this->users->getByEmail($email);

        if($user == null || !password_verify($password, $user->getPassword()))
        {
            return false;
        }

        $api_key = bin2hex(openssl_random_pseudo_bytes(32));

        $this->session->store('auth', [
            'id' => $user->getUuid()->toString(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail(),
            'api_key' => $api_key
        ]);

        return true;
    }

    /**
     * This class does not require implementation.
     *
     * @return void
     */
    public function handleCallback(): void
    {
        
    }

    public function verify(): bool
    {
        if(!$this->session->exists('auth'))
        {
            return false;
        }

        $state = $this->session->get('auth');

        $user = $this->users->getByEmail($state['email']);

        if($user == null)
        {
            return false;
        }

        return true;
    }

    public function clear(): void
    {
        if($this->session->exists('auth'))
        {
            $this->session->delete('auth');
        }
    }
}