<?php

/**
 * Local User Account Model.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 27/02/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\ManyToMany;

#[Entity, Table(name: 'users')]
class User
{
    #[Id, Column(type: "uuid", unique: true)]
    #[GeneratedValue(strategy: "CUSTOM")]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'email', type:'string')]
    private string $email;

    #[Column(name:'password', type:'string')]
    private string $password;

    #[Column(name: 'first_name', type: 'string', nullable: true)]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string', nullable: true)]
    private string $last_name;

    #[Column(name: 'mobile', type: 'string', nullable: true)]
    private string $mobile;

    #[ManyToOne(targetEntity: Group::class, inversedBy: 'users')]
    private Group|null $group;

    #[OneToMany(targetEntity: Device::class, mappedBy: 'user')]
    private Collection|null $devices;

    #[ManyToMany(targetEntity: Ticket::class)]
    private Collection|null $tickets;

    #[OneToMany(targetEntity: Note::class, mappedBy: 'author')]
    private Collection|null $notes;

    #[Column(name:'created', type:'datetime')]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct()
    {
        $this->devices = new ArrayCollection();
        $this->tickets = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    /**
     * Get the value of id
     */ 
    public function getId(): UuidInterface|string
    {
        return $this->id;
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
    public function setPassword($password): void
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
    public function setMobile(string $mobile): void
    {
        $this->mobile = $mobile;
    }

    /**
     * Get the value of group
     */ 
    public function getGroup(): Group|null
    {
        return $this->group;
    }

    /**
     * Set the value of group
     */ 
    public function setGroup(Group $group): void
    {
        $this->group = $group;
    }

    /**
     * Get the value of devices
     */ 
    public function getDevices(): Collection|null
    {
        return $this->devices;
    }

    /**
     * Set the value of devices
     */ 
    public function setDevice(Device $device): void
    {
        
    }

    /**
     * Get the value of tickets
     */ 
    public function getTickets(): Collection|null
    {
        return $this->tickets;
    }

    /**
     * Set the value of tickets
     */ 
    public function setTickets(Ticket $ticket): void
    {
        $this->tickets = $ticket;
    }

    /**
     * Get the value of notes
     */ 
    public function getNotes(): Collection|null
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     */ 
    public function setNotes(Note $note): void
    {
        $this->notes = $note;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated(): DateTime
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
    public function getUpdated(): DateTime
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