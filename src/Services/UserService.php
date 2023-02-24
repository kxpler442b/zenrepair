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

class UserService implements UserProviderInterface
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

    public function create(array $data) : void
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
        $this->em->flush();
    }

    public function getById(string $id): User|null
    {
        return $this->em->find(User::class, $id);
    }

    public function getByEmail(string $email): User|null
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function update(string $id, array $data): void
    {
        $customer = $this->em->find(User::class, $id);

        $customer->setFirstName($data['first_name']);
    }

    public function delete(string $id): void
    {
        
    }
}