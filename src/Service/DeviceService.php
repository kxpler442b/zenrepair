<?php

/**
 * User Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\Device;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class DeviceService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->setRepository();
    }

    public function __destruct() {}

    public function create(array $data): void
    {
        $device = new Device;

        $device->setManufacturer($data['manufacturer']);
        $device->setModel($data['model']);
        $device->setSerial($data['serial']);
        $device->setImei($data['imei']);
        $device->setLocator($data['locator']);
        $device->setCustomer($data['owner']);
        $device->setUuid();
        $device->setCreated();
        $device->setUpdated();
        
        $this->em->persist($device);
        $this->em->flush();

    }

    public function getByUuid(string $uuid): ?Device
    {
        return $this->repo->findOneBy(['uuid' => $uuid]);
    }

    public function getBySerial(string $serial): ?Device
    {
        return $this->em->getRepository(Device::class)->findOneBy(['serial' => $serial]);
    }

    public function getAll() : array
    {
        return $this->em->getRepository(Device::class)->findAll();
    }

    public function search(string $search): ?array
    {
        $qb = $this->repo->createQueryBuilder('d');

        $result = $qb->where($qb->expr()->orX(
                                $qb->expr()->like('d.manufacturer', ':search'),
                                $qb->expr()->like('d.model', ':search'),
                                $qb->expr()->like('d.serial', ':search')
                            ))
                    ->setParameter('search', implode('', [$search, '%']))
                    ->getQuery()
                    ->getResult();

        return $result;
    }

    public function update(string $id, array $data): void
    {
        $customer = $this->em->find(Device::class, $id);

        $customer->setFirstName($data['model']);
    }

    public function delete(string $uuid): void
    {
        $device = $this->getByUuid($uuid);

        $this->em->remove($device);
        $this->em->flush();
    }

    private function setRepository(): void
    {
        $this->repo = $this->em->getRepository(Device::class);
    }
}