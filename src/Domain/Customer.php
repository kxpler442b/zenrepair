<?php

/**
 * Customer object model.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 10/02/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use App\Trait\EntityId;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity, Table(name: 'customers')]
class Customer
{
    use EntityId;

    #[Column(name: 'email', type: 'string')]
    private string $email;

    #[Column(name: 'password', type: 'string')]
    private string $password;

    #[Column(name: 'first_name', type: 'string')]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string', nullable: true)]
    private string $last_name;

    #[Column(name: 'mobile', type: 'string')]
    private string $mobile;

    #[OneToMany(targetEntity: Address::class, mappedBy: 'customer')]
    private ?Collection $addresses;

    #[OneToMany(targetEntity: Device::class, mappedBy: 'owner')]
    private ?Collection $devices;

    #[OneToMany(targetEntity: Ticket::class, mappedBy: 'customer')]
    private ?Collection $tickets;

    #[Column(name:'created', type:'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->devices = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    /**
     * Get the value of email
     */ 
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */ 
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */ 
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of first_name
     */ 
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     */ 
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLastName(): string
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     */ 
    public function setLastName(string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * Get the value of mobile
     */ 
    public function getMobile(): string
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     */ 
    public function setMobile(string $mobile = null): void
    {
        $this->mobile = $mobile;
    }

    /**
     * Get the value of addresses
     */ 
    public function getAddresses(): ?Collection
    {
        return $this->addresses;
    }

    /**
     * Set the value of addresses
     */ 
    public function setAddresses(Address $addresses = null): void
    {
        $this->addresses = $addresses;
    }

    /**
     * Get the value of devices
     */ 
    public function getDevices(): ?Collection
    {
        return $this->devices;
    }

    /**
     * Set the value of devices
     */ 
    public function setDevices(Device $device = null): void
    {
        $this->devices = $device;
    }

    /**
     * Get the value of tickets
     */ 
    public function getTickets(): ?Collection
    {
        return $this->tickets;
    }

    /**
     * Set the value of tickets
     */ 
    public function setTickets(Ticket $ticket = null): void
    {
        $this->tickets = $ticket;
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