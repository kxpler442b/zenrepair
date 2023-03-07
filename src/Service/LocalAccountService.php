<?php

/**
 * Local Account Service.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 27/02/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\User;
use App\Domain\Group;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use App\Interface\LocalAccountProviderInterface;

class LocalAccountService implements LocalAccountProviderInterface
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $userRepo;
    private ObjectRepository|EntityRepository $groupRepo;

    /**
     * Constructor method
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->setUserRepository();
        $this->setGroupRepository();
    }

    public function __destruct() {}

    public function createAccount(array $data): void
    {
        $user = new User();
        $group = $this->getGroupByName($data['group'] ?? 'default');

        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]));
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name'] ?? 'null');
        $user->setGroup($group);
        $user->setUuid();
        $user->setCreated();
        $user->setUpdated();

        $this->em->persist($user);
        $this->em->flush();
    }

    public function createGroup(array $data): void
    {
        $group = new Group();

        $group->setName($data['name']);
        $group->setPrivLevel($data['priv_level'] ?? 3);
        $group->setUuid();
        $group->setCreated();
        $group->setUpdated();

        $this->em->persist($group);
        $this->em->flush();
    }

    public function getAccountByUuid(string $uuid): ?User
    {
        return $this->userRepo->findOneBy(['uuid' => $uuid]);
    }

    public function getAccountByEmail(string $email): ?User
    {
        return $this->userRepo->findOneBy(['email' => $email]);
    }

    public function getAccountByGroup(string $group_id): ?User
    {
        return $this->userRepo->findOneBy(['id' => $group_id]);
    }

    public function getAccountsInGroup(string $group_name): ?array
    {
        $group = $this->getGroupByName($group_name);

        return $this->userRepo->findBy(['group' => $group->getUuid()->toString()]);
    }

    public function getGroupById(string $uuid): ?Group
    {
        return $this->groupRepo->findOneBy(['uuid' => $uuid]);
    }

    public function getGroupByName(string $name): ?Group
    {
        return $this->groupRepo->findOneBy(['name' => $name]);
    }

    public function updateAccount(string $id, array $data): void
    {
        // TODO: Implement account update function.
    }

    public function deleteAccount(string $id): void
    {
        // TODO: Implement account deletion function.
    }

    private function setUserRepository(): void
    {
        $this->userRepo = $this->em->getRepository(User::class);
    }

    private function setGroupRepository(): void
    {
        $this->groupRepo = $this->em->getRepository(Group::class);
    }
}