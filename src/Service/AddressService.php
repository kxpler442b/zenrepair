<?php

/**
 * Addresses Service.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 07/03/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\Address;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\Common\Collections\Collection;

class AddressService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;
    
    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->setRepository();
    }

    public function create(array $data): ?Address
    {
        $address = new Address;

        $address->setLineOne($data['line_one']);
        $address->setLineTwo($data['line_two'] ?? null);
        $address->setTown($data['town']);
        $address->setCounty($data['county']);
        $address->setPostcode($data['postcode']);
        $address->setCustomer($data['customer']);

        $address->setUuid();
        $address->setCreated();
        $address->setUpdated();

        $this->em->persist($address);
        $this->em->flush();

        return $address;
    }

    public function getById(int $id): ?Address
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function getByUuid(string $uuid): ?Address
    {
        return $this->repo->findOneBy(['uuid' => $uuid]);
    }

    public function getAll(): ?Collection
    {
        return $this->repo->getAll();
    }

    public function update(string $uuid, array $data): void
    {

    }

    public function delete(string $uuid): void
    {
        $address = $this->getByUuid($uuid);

        $this->em->remove($address);
        $this->em->flush();
    }

    private function setRepository(): void
    {
        $this->em->getRepository(Address::class);
    }
}