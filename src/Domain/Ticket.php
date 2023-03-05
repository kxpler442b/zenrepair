<?php

/**
 * Ticket entity mapping.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity, Table(name: 'tickets')]
class Ticket
{
    #[Id, Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'title', type:'string')]
    private string $title;

    #[Column(name:'status', type:'integer')]
    private int $status;

    #[OneToMany(targetEntity: Note::class, mappedBy: 'ticket')]
    private ?Collection $notes;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'tickets')]
    private ?User $user;

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'tickets')]
    private ?Customer $customer;

    #[OneToOne(targetEntity: Device::class, inversedBy: 'ticket')]
    private ?Device $device;

    #[Column(name:'created', type:'datetime')]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct() 
    {
        $this->notes = new ArrayCollection();
    }

    public function __destruct() {}

    /**
     * Get the value of id
     */ 
    public function getId(): UuidInterface|string
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */ 
    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */ 
    public function setStatus(int $status = 0)
    {
        $this->status = $status;
    }

    /**
     * Get the value of notes
     */ 
    public function getNotes() : Collection
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     */ 
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * Get the value of user
     */ 
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */ 
    public function setUser(User $user = null): void
    {
        $this->user = $user;
    }

    /**
     * Get the value of customer
     */ 
    public function getCustomer() : ?Customer
    {
        return $this->customer;
    }

    /**
     * Set the value of user
     */ 
    public function setCustomer(Customer $customer = null): void
    {
        $this->customer = $customer;
    }

    /**
     * Get the value of device
     */ 
    public function getDevice() : Device
    {
        return $this->device;
    }

    /**
     * Set the value of device
     */ 
    public function setDevice(Device $device)
    {
        $this->device = $device;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated() : DateTime
    {
        return $this->created;
    }

    /**
     * Set the value of created
     */ 
    public function setCreated() : void
    {
        $this->created = new DateTime('now');
    }

    /**
     * Get the value of updated
     */ 
    public function getUpdated() : DateTime
    {
        return $this->updated;
    }

    /**
     * Set the value of updated
     */ 
    public function setUpdated() : void
    {
        $this->updated = new DateTime('now');
    }
}