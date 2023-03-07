<?php

/**
 * Device entity mapping for Doctrine.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use App\Trait\EntityId;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity, Table(name: 'devices')]
class Device
{
    use EntityId;

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

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'devices')]
    private ?Customer $owner;

    #[OneToOne(targetEntity: Ticket::class, mappedBy: 'device')]
    private ?Ticket $ticket;

    #[Column(name:'created', type:'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct() {}

    /**
     * Get the value of manufacturer
     */ 
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * Set the value of manufacturer
     */ 
    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * Get the value of model
     */ 
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * Set the value of model
     */ 
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * Get the value of imei
     */ 
    public function getImei(): string
    {
        return $this->imei;
    }

    /**
     * Set the value of imei
     */ 
    public function setImei(string $imei): void
    {
        $this->imei = $imei;
    }

    /**
     * Get the value of serial
     */ 
    public function getSerial(): string
    {
        return $this->serial;
    }

    /**
     * Set the value of serial
     */ 
    public function setSerial(string $serial): void
    {
        $this->serial = $serial;
    }

    /**
     * Get the value of ticket
     */ 
    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    /**
     * Set the value of ticket
     */ 
    public function setTicket(Ticket $ticket = null): void
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the value of customer
     */ 
    public function getCustomer(): ?Customer
    {
        return $this->owner;
    }

    /**
     * Set the value of customer
     */ 
    public function setCustomer(Customer $owner = null) : void
    {
        $this->owner = $owner;
    }

    /**
     * Get the value of locator
     */ 
    public function getLocator(): string
    {
        return $this->locator;
    }

    /**
     * Set the value of locator
     */ 
    public function setLocator(string $locator): void
    {
        $this->locator = $locator;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Set the value of created
     */ 
    public function setCreated(): void
    {
        $this->created = new DateTime('now');
    }

    /**
     * Get the value of updated
     */ 
    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    /**
     * Set the value of updated
     */ 
    public function setUpdated(): void
    {
        $this->updated = new DateTime('now');
    }
}