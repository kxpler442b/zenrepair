<?php

/**
 * User entity for Doctrine.
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
use Doctrine\ORM\Mapping\JoinTable;

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

    #[Column(name: 'mobile', type: 'string', nullable: true)]
    private string $mobile;

    #[Column(name: 'first_name', type: 'string', nullable: true)]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string', nullable: true)]
    private string $last_name;

    #[Column(name: 'is_admin', type: 'boolean')]
    private bool $is_admin;

    #[OneToMany(targetEntity: Ticket::class, mappedBy: 'user')]
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

    /**
     * Get the value of email
     */ 
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of mobile
     */ 
    public function getMobile() : string
    {
        return $this->mobile;
    }

    /**
     * Set the value of mobile
     *
     * @return  self
     */ 
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get the value of first_name
     */ 
    public function getFirstName() : string
    {
        return $this->first_name;
    }

    /**
     * Set the value of first_name
     *
     * @return  self
     */ 
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * Get the value of last_name
     */ 
    public function getLastName() : string
    {
        return $this->last_name;
    }

    /**
     * Set the value of last_name
     *
     * @return  self
     */ 
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * Get the value of is_admin
     */ 
    public function getIsAdmin() : bool
    {
        return $this->is_admin;
    }

    /**
     * Set the value of is_admin
     *
     * @return  self
     */ 
    public function setIsAdmin($is_admin)
    {
        $this->is_admin = $is_admin;

        return $this;
    }

    /**
     * Get the value of tickets
     */ 
    public function getTickets() : Collection
    {
        return $this->tickets;
    }

    /**
     * Set the value of tickets
     *
     * @return  self
     */ 
    public function setTickets(Ticket $tickets)
    {
        $this->tickets = $tickets;

        return $this;
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