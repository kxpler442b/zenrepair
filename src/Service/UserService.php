<?php

/**
 * User Accounts Service.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\User;
use Ramsey\Uuid\Uuid;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Psr\Container\ContainerInterface;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\Common\Collections\Collection;

class UserService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;

    /**
     * Constructor method.
     *
     * @param ContainerInterface $c
     */
    public function __construct(ContainerInterface $c)
    {
        $this->em = $c->get(EntityManager::class);
        
        $this->getRepository();
    }

    /**
     * Returns a User object or null.
     *
     * @param integer $id
     * 
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    /**
     * Returns a User object or null.
     *
     * @param Uuid $uuid
     * 
     * @return User|null
     */
    public function getByUuid(Uuid $uuid): ?User
    {
        return $this->repo->findOneBy(['uuid' => $uuid]);
    }

    /**
     * Returns a doctrine collection of Users.
     *
     * @return Collection|null
     */
    public function getAll(): ?Collection
    {
        return $this->repo->getAll();
    }

    /**
     * Sets the private repository class.
     *
     * @return void
     */
    private function getRepository(): void
    {
        $this->em->getRepository(User::class);
    }
}