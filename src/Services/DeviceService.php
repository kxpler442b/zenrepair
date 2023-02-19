<?php

/**
 * User Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Domain\Device;
use App\Domain\Customer;
use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\Rfc4122\UuidInterface;

class DeviceService
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
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
        $device->setCustomer($data['customer']);
        $device->setCreated();
        $device->setUpdated();
        
        $this->em->persist($device);
        $this->em->flush();

    }

    public function getById(string $id): Device
    {
        return $this->em->find(Device::class, $id);
    }

    public function getBySerial(string $serial): Device
    {
        return $this->em->getRepository(Device::class)->findOneBy(['serial' => $serial]);
    }

    public function update(UuidInterface $id, array $data): void
    {
        $customer = $this->em->find(Device::class, $id);

        $customer->setFirstName($data['model']);
    }

    public function delete(UuidInterface $id): void
    {
        
    }
}