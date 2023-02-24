<?php

/**
 * Local authentication system.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 23/02/22
 */

declare(strict_types = 1);

namespace App;

use App\Domain\User;
use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;
use App\Contracts\UserProviderInterface;

class LocalAuth implements AuthInterface
{
    private User|null $user;
    private readonly UserProviderInterface $userProvider;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     *
     * @param UserProviderInterface $user
     * @param SessionInterface $session
     */
    public function __construct(UserProviderInterface $userProvider, SessionInterface $session)
    {
        $this->user = null;
        $this->userProvider = $userProvider;
        $this->session = $session;
    }

    public function __destruct() {}

    public function verify() : bool
    {
        return true;
    }

    public function attemptAuth(string $email, string $password): bool
    {
        $user = $this->userProvider->getByEmail($email);

        if($user = null || !$this->checkPassword($password, $user->getPassword()))
        {
            return false;
        }

        $this->auth($user);

        return true;
    }

    public function auth(User $user) : void
    {
        $this->session->regenerate();
        $this->session->store('user_id', $user->getId()->toString());
        $this->session->store('user_info', [
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => $user->getEmail()
        ]);

        $this->user = $user;
    }

    public function getUser() : User|null
    {
        return $this->user;
    }

    public function checkPassword(string $password, string $hash) : bool
    {
        if(password_verify($password, $hash))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function deauth(): void
    {
        $this->session->clear();
        $this->session->regenerate();

        $this->user = null;
    }
}