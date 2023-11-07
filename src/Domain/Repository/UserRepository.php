<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use DateTime;
use App\Domain\Entity\UserEntity;
use Doctrine\ORM\EntityRepository;
use App\Domain\XferObject\UserCredentialsObject;

class UserRepository extends EntityRepository
{
    public function new(UserCredentialsObject $credentials): UserEntity
    {
        $dt = new DateTime('now');

        $user = (new UserEntity())
            ->setUsername($credentials->username)
            ->setPassword($credentials->password)
            ->setEmail($credentials->email)
            ->setGivenName($credentials->given_name)
            ->setFamilyName($credentials->family_name)
            ->setCreated($dt)
            ->setUpdated($dt);


        return $user;
    }

    public function save(UserEntity $user): void
    {
        $this->_em->persist($user);

        $this->_em->flush();
    }
}