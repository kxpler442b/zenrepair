<?php

/**
 * Local authentication system.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 23/02/22
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\User;
use App\Interface\SessionInterface;
use App\Service\LocalAccountService;
use App\Interface\LocalAuthInterface;
use App\Interface\LocalAccountProviderInterface;

class LocalAuthService implements LocalAuthInterface
{
    private ?User $user;
    private readonly LocalAccountService $accountProvider;
    private readonly SessionInterface $session;

    /**
     * Constructor method.
     *
     * @param UserProviderInterface $user
     * @param SessionInterface $session
     */
    public function __construct(LocalAccountProviderInterface $accountProvider, SessionInterface $session)
    {
        $this->user = null;
        $this->accountProvider = $accountProvider;
        $this->session = $session;
    }

    public function __destruct() {}

    public function verify()
    {
        if ($this->user !== null) {
            return $this->user;
        }

        $userUuid = $this->session->get('user_uuid');

        if (! $userUuid) {
            return null;
        }

        $user = $this->accountProvider->getAccountByUuid($userUuid);

        if (!$user) {
            return null;
        }

        $this->user = $user;

        return $this->user;
    }

    public function attemptAuth(string $email, string $password)
    {
        $user = $this->accountProvider->getAccountByEmail($email);

        if($user === null || !$this->checkPassword($password, $user->getPassword()))
        {
            return false;
        }

        $this->auth($user);

        return true;
    }

    public function auth(User $user) : void
    {
        $this->session->regenerate();
        $this->session->store('user_uuid', $user->getUuid()->toString());
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
        $this->session->destroy();
        $this->session->regenerate();

        $this->user = null;
    }
}