<?php

declare(strict_types = 1);

namespace App\Service;

use Doctrine\ORM\EntityManager;
use App\Domain\Entity\UserEntity;
use Doctrine\ORM\EntityRepository;
use App\Authenticator\Authenticator;
use App\Domain\Enum\UserEnum;
use Psr\Container\ContainerInterface;
use App\Domain\XferObject\UserCredentialsObject;

final class UserService extends Service
{
    private Authenticator $authenticator;
    private EntityRepository $users;

    public function __construct(ContainerInterface $c)
    {
        $this->authenticator = $c->get(Authenticator::class);
        $this->users = $c->get(EntityManager::class)->getRepository(UserEntity::class);

        parent::__construct($c);
    }

    public function createUser(UserCredentialsObject $credentials): UserEntity
    {
        $password = $this->authenticator->createPasswordHash(
            $credentials->password
        );

        $user = (new UserEntity())
            ->setUsername($credentials->username)
            ->setPassword($password)
            ->setEmail($credentials->email)
            ->setGivenName($credentials->given_name)
            ->setFamilyName($credentials->family_name);

        return $user;
    }

    public function find(array $criteria): ?UserEntity
    {
        return $this->users->findOneBy($criteria);
    }

    public function persistUser(UserEntity $user): self
    {
        $this->users->persist($user);

        return $this;
    }
}