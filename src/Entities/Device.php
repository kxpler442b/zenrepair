<?php

/**
 * Device entity for Doctrine.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\ManyToOne;
use DateTimeImmutable;

#[Entity, Table(name: 'devices')]
class Device
{
    #[Id, Column(name: 'id', )]
    private int $id;

    #[Column(name:'serial_number', type:'string', nullable: false, unique: true)]
    private string $serial_number;

    #[Column(name:'imei', type:'string')]
    private string $imei;

    #[Column(name: 'model', type: 'string')]
    private string $model;

    #[Column(name: 'manufacturer', type: 'string')]
    private string $manufacturer;

    #[Column(name: 'location', type: 'string')]
    private string $location;

    #[ManyToOne(targetEntity: Customer::class)]
    private int $assoc_customer;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct(string $serial_number, string $manufacturer, string $model)
    {
        $this->serial_number = $serial_number;
        $this->manufacturer = $manufacturer;
        $this->model = $model;
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getSerialNumber() : string
    {
        return $this->serial_number;
    }

    public function getImei() : string
    {
        return $this->imei;
    }

    public function getModel() : string
    {
        return $this->model;
    }

    public function getManufacturer() : string
    {
        return $this->manufacturer;
    }

    public function getLocation() : string
    {
        return $this->location;
    }

    public function getAssocCustomer() : int
    {
        return $this->assoc_customer;
    }

    public function getCreated() : DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated() : DateTimeImmutable
    {
        return $this->updated;
    }
}