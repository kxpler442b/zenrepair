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
use App\Trait\EntityId;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity, Table(name: 'tickets')]
class Ticket
{
    use EntityId;

    #[Column(name:'subject', type:'string')]
    private string $subject;

    #[Column(name:'issue_type', type:'string', nullable: true)]
    private string $issue_type;

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

    #[Column(name:'created', type:'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    #[Column(name:'closed', type:'datetime', nullable: true)]
    private DateTime $closed;

    public function __construct() 
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * Get the value of subject
     */ 
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     */ 
    public function setSubject(string $subject = 'subject'): void
    {
        $this->subject = $subject;
    }

    /**
     * Get the value of issue_type
     */ 
    public function getIssueType(): string
    {
        return $this->issue_type;
    }

    /**
     * Set the value of issue_type
     */ 
    public function setIssueType(string $issue_type = 'not set'): void
    {
        $this->issue_type = $issue_type;
    }

    /**
     * Get the value of status
     */ 
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */ 
    public function setStatus(int $status = 0): void
    {
        $this->status = $status;
    }

    /**
     * Get the value of notes
     */ 
    public function getNotes(): ?Collection
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     */ 
    public function setNotes(Collection $notes): void
    {
        $this->notes = $notes;
    }

    /**
     * Get the value of user
     */ 
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * Set the value of user
     */ 
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Get the value of customer
     */ 
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * Set the value of customer
     */ 
    public function setCustomer(Customer $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * Get the value of device
     */ 
    public function getDevice(): ?Device
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
    public function setUpdated()
    {
        $this->updated = new DateTime('now');
    }

    /**
     * Get the value of closed
     */ 
    public function getClosed()
    {
        return $this->closed;
    }

    /**
     * Set the value of closed
     */ 
    public function setClosed()
    {
        $this->closed = new DateTime('now');
    }
}