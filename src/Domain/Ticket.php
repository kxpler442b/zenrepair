<?php

/**
 * Ticket entity mapping.
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

use DateTime;
use Doctrine\Common\Collections\Collection;

#[Entity, Table(name: 'tickets')]
class Ticket
{
    #[Id, Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'subject', type:'string')]
    private string $subject;

    #[Column(name:'status', type:'integer')]
    private int $status;

    #[Column(name:'notes', type:'json')]
    private string $notes;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'tickets')]
    private User|null $user;

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'tickets')]
    private Customer|null $customer;

    #[OneToOne(targetEntity: Device::class, inversedBy: 'ticket')]
    private Collection|null $device;

    #[Column(name:'created', type:'datetime')]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct() {}

    public function getId() : UuidInterface | string
    {
        return $this->id;
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getNotes() : string
    {
        return $this->notes;
    }

    public function setNotes(string $notes)
    {
        
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : void
    {
        $this->user = $user;
    }

    public function getCustomer() : Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer) : void
    {
        $this->customer = $customer;
    }

    public function getDevice() : Collection
    {
        return $this->device;
    }

    public function setDevice(Device $device) : void
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