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
use App\Trait\EntityId;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity, Table(name: 'users')]
class User
{
    use EntityId;

    #[Column(name:'email', type:'string')]
    private string $email;

    #[Column(name:'password', type:'string')]
    private string $password;

    #[Column(name: 'first_name', type: 'string', nullable: true)]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string', nullable: true)]
    private string $last_name;

    #[ManyToOne(targetEntity: Group::class, inversedBy: 'users')]
    private ?Group $group;

    #[OneToMany(targetEntity: Ticket::class, mappedBy: 'user')]
    private ?Collection $tickets;

    #[OneToMany(targetEntity: Note::class, mappedBy: 'author')]
    private ?Collection $notes;

    #[Column(name:'created', type:'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->notes = new ArrayCollection();
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