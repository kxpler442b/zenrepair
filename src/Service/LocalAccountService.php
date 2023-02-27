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
use App\Interface\LocalAccountProviderInterface;
use Doctrine\Common\Collections\Collection;

class LocalAccountService implements LocalAccountProviderInterface
{
    private readonly EntityManager $em;

    /**
     * Constructor method
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
        $user->setMobile($data['mobile'] ?? 'null');
        $user->setGroup($group);
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
        $group->setCreated();
        $group->setUpdated();

        $this->em->persist($group);
        $this->em->flush();
    }

    public function getAccountById(string $id): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['id' => $id]);
    }

    public function getAccountByEmail(string $email): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['email' => $email]);
    }

    public function getAccountByGroup(string $group_id): ?User
    {
        return $this->em->getRepository(User::class)->findOneBy(['id' => $group_id]);
    }

    public function getAccountsInGroup(string $group_name): ?array
    {
        $group = $this->getGroupByName($group_name);

        return $this->em->getRepository(User::class)->findBy(['group' => $group->getId()->toString()]);
    }

    public function getGroupById(string $id): ?Group
    {
        return $this->em->getRepository(Group::class)->findOneBy(['id' => $id]);
    }

    public function getGroupByName(string $name): ?Group
    {
        return $this->em->getRepository(Group::class)->findOneBy(['name' => $name]);
    }

    public function updateAccount(string $id, array $data): void
    {
        // TODO: Implement account update function.
    }

    public function deleteAccount(string $id): void
    {
        // TODO: Implement account deletion function.
    }
}