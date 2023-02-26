<?php

/**
 * Customer entity for Doctrine.
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
use Doctrine\ORM\Mapping\OneToMany;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use DateTime;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity, Table(name: 'customers')]
class Customer
{
    #[Id, Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'email', type:'string')]
    private string $email;

    #[Column(name:'password', type:'string')]
    private string $password;

    #[Column(name: 'mobile', type: 'string', nullable: true)]
    private string $mobile;

    #[Column(name: 'first_name', type: 'string')]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string')]
    private string $last_name;

    #[ManyToOne(targetEntity: Group::class, inversedBy: 'customers')]
    private Group|null $group;

    #[OneToMany(targetEntity: Device::class, mappedBy: 'customer')]
    private Collection|null $devices;

    #[OneToMany(targetEntity: Ticket::class, mappedBy: 'customer')]
    private Collection|null $tickets;

    #[Column(name:'created', type:'datetime')]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct() {}

    public function getId() : UuidInterface | string
    {
        return $this->id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getMobile() : string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile)
    {
        $this->mobile = $mobile;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name)
    {
        $this->first_name = $first_name;
    }

    public function getLastName() : string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * Get the value of group
     *
     * @return Group|null
     */
    public function getGroup() : Group|null
    {
        return $this->group;
    }

    /**
     * Set the value of group
     */ 
    public function setGroup(Group $group) : void
    {
        $this->group = $group;
    }

    /**
     * Get the value of tickets
     */ 
    public function getTickets()
    {
        return $this->tickets;
    }

    /**
     * Set the value of tickets
     *
     * @return  self
     */ 
    public function setTickets($tickets)
    {
        $this->tickets = $tickets;

        return $this;
    }

    /**
     * Get the value of devices
     */ 
    public function getDevices()
    {
        return $this->devices;
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