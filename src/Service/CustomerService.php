<?php

/**
 * Customer Accounts Service.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\Customer;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class CustomerService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        
        $this->repo = $em->getRepository(Customer::class);
    }

    public function create(array $data): ?Customer
    {
        $password = 'hello';

        $customer = new Customer;

        $customer->setEmail($data['email']);
        $customer->setPassword(password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]));
        $customer->setFirstName($data['first_name']);
        $customer->setLastName($data['last_name']);
        $customer->setMobile($data['mobile']);
        $customer->setUuid();
        $customer->setCreated();
        $customer->setUpdated();

        $this->em->persist($customer);
        $this->em->flush();

        return $customer;
    }

    public function getByUuid(string $uuid): ?Customer
    {
        return $this->repo->findOneBy(['uuid' => $uuid]);
    }

    public function getByEmail(string $email): ?Customer
    {
        return $this->repo->findOneBy(['email' => $email]);
    }

    public function getAll(): ?array
    {
        return $this->repo->findAll();
    }

    public function search(string $search): ?array
    {
        $qb = $this->repo->createQueryBuilder('c');

        $result = $qb->where($qb->expr()->orX(
                                $qb->expr()->like('c.email', ':search'),
                                $qb->expr()->like('c.first_name', ':search'),
                                $qb->expr()->like('c.last_name', ':search'),
                                $qb->expr()->like('c.mobile', ':search')
                            ))
                    ->setParameter('search', implode('', [$search, '%']))
                    ->getQuery()
                    ->getResult();

        return $result;
    }

    public function update(string $uuid, array $data): bool
    {
        $customer = $this->getByUuid($uuid);

        // TODO: Update data function.

        return false;
    }

    public function delete(string $uuid): void
    {
        $customer = $this->getByUuid($uuid);

        $this->em->remove($customer);
        $this->em->flush();
    }
}