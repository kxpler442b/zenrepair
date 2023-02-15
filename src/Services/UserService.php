<?php

/**
 * User Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\UserProviderInterface;
use App\Domain\User;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Rfc4122\UuidInterface;

class UserService implements UserProviderInterface
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

    public function createUser(array $data)
    {
        $user = new User;

        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setMobile($data['mobile']);
        $user->setIsAdmin($data['is_admin']);
        $user->setCreated();
        $user->setUpdated();

        $this->em->persist($user);
        $this->em->flush($user);
    }

    public function getById(UuidInterface $uuid)
    {
        $this->em->find(User::class, $uuid);

        return $this;
    }

    public function getByEmail(string $email)
    {
        $this->em->find(User::class, $email);

        return $this;
    }
}