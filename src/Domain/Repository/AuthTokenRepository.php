<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use Doctrine\ORM\EntityRepository;
use App\Domain\Entity\AuthTokenEntity;
use App\Domain\Entity\UserEntity;
use DateTime;

class AuthTokenRepository extends EntityRepository
{
    public function new(UserEntity $user): AuthTokenEntity
    {
        $dt = new DateTime('now');

        $token = (new AuthTokenEntity())
            ->setOwner($user)
            ->setCreated($dt)
            ->setUpdated($dt)
            ->setExpires($dt);

        return $token;
    }

    public function save(AuthTokenEntity $token): self
    {
        $this->_em->persist($token);

        $this->_em->flush();

        return $this;
    }
}