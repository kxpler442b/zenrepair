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
use App\Domain\Customer;
use App\Contracts\LocalAuthInterface;

use Doctrine\ORM\EntityManager;

class LocalAuthService implements LocalAuthInterface
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

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

    public function checkUserAuthStatus(User $user)
    {
        
    }
}