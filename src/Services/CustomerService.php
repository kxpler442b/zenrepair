<?php

/**
 * User Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Contracts\CustomerProviderInterface;
use App\Domain\Customer;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Rfc4122\UuidInterface;

class CustomerService implements CustomerProviderInterface
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

    public function create(array $data): void
    {
        $customer = new Customer;

        $password = password_hash($data['password'], PASSWORD_BCRYPT);

        $customer->setEmail($data['email']);
        $customer->setPassword($password);
        $customer->setFirstName($data['first_name']);
        $customer->setLastName($data['last_name']);
        $customer->setMobile($data['mobile']);
        $customer->setCreated();
        $customer->setUpdated();
        
        $this->em->persist($customer);
        $this->em->flush();

    }

    public function getById(string $id): Customer
    {
        return $this->em->find(Customer::class, $id);
    }

    public function getByEmail(string $email): Customer
    {
        return $this->em->getRepository(Customer::class)->findOneBy(['email' => $email]);
    }

    public function getAll() : array
    {
        $customers = $this->em->getRepository(Customer::class)->findAll();

        return $customers;
    }

    public function update(string $id, array $data): void
    {
        $customer = $this->em->find(Customer::class, $id);

        $customer->setFirstName($data['first_name']);
    }

    public function delete(string $id): void
    {
        
    }
}