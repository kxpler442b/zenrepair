<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use App\Auth\Interface\LocalUserInterface;
use App\Auth\Interface\LocalUserRepositoryInterface;
use App\Domain\Entity\LocalUserEntity;

class LocalUserRepository extends EntityRepository implements LocalUserRepositoryInterface
{
    public function getNewUser(array $credentials): LocalUserInterface
    {
        $localUser = new LocalUserEntity();

        $localUser->setEmail($credentials['email']);
        $localUser->setPassword($credentials['password']);

        return $localUser;
    }

    public function persistUser(LocalUserInterface $localUser): void
    {
        $this->_em->persist($localUser);
    }

    public function getUserByCredentials(array $credentials): ?LocalUserInterface
    {
        return $this->findOneBy($credentials);
    }

    public function removeUser(LocalUserInterface $localUser): void
    {
        $this->_em->remove($localUser);
    }
}