<?php

/**
 * Device entity mapping for Doctrine.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Domain;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use DateTimeImmutable;

#[Entity, Table(name: 'devices')]
class Device
{
    #[Id, Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'manufacturer', type:'string')]
    private string $manufacturer;

    #[Column(name:'model', type:'string')]
    private string $model;

    #[Column(name: 'serial', type: 'string', unique: true, nullable: false)]
    private string $serial;

    #[Column(name: 'imei', type: 'string')]
    private string $imei;

    #[Column(name: 'locator', type: 'string')]
    private string $locator;

    #[Column(name: 'customer')]
    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'devices')]
    private Customer|null $customer;

    #[Column(name:'ticket')]
    #[OneToOne(targetEntity: Ticket::class, inversedBy: 'device')]
    private UuidInterface|string $ticket;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct()
    {
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getId() : UuidInterface | string
    {
        return $this->id;
    }

    /**
     * Get the value of manufacturer
     */ 
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set the value of manufacturer
     *
     * @return  self
     */ 
    public function setManufacturer(string $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get the value of model
     */ 
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the value of model
     *
     * @return  self
     */ 
    public function setModel(string $model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the value of imei
     */ 
    public function getImei()
    {
        return $this->imei;
    }

    /**
     * Set the value of imei
     *
     * @return  self
     */ 
    public function setImei(string $imei)
    {
        $this->imei = $imei;

        return $this;
    }

    /**
     * Get the value of serial
     */ 
    public function getSerial()
    {
        return $this->serial;
    }

    /**
     * Set the value of serial
     *
     * @return  self
     */ 
    public function setSerial(string $serial)
    {
        $this->serial = $serial;

        return $this;
    }

    /**
     * Get the value of ticket
     */ 
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set the value of ticket
     *
     * @return  self
     */ 
    public function setTicket(Ticket $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get the value of customer
     */ 
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     *
     * @return  self
     */ 
    public function setCustomer($customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get the value of locator
     */ 
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Set the value of locator
     *
     * @return  self
     */ 
    public function setLocator(string $locator)
    {
        $this->locator = $locator;

        return $this;
    }
}