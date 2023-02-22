<?php

/**
 * Authentication Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Domain\User;
use Doctrine\ORM\EntityManager;
use App\Contracts\AuthInterface;
use App\Contracts\SessionInterface;

class LocalAuthService implements AuthInterface
{
    private readonly EntityManager $em;
    private readonly SessionInterface $session;

    public function __construct(EntityManager $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    public function authUserByPassword(string $email, string $password) : bool
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

        $stored_password = $user->getPassword();

        if (password_verify($password, $stored_password))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkUserAuthStatus(string $id) : bool
    {
        $user = $this->em->getRepository(User::class)->findOneBy(['id' => $id]);

        return $user->getId() === $id;
    }
}