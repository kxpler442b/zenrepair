<?php

/**
 * User accounts group model.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 19/02/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\OneToMany;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\Common\Collections\ArrayCollection;

#[Entity, Table(name: 'groups')]
class Group
{
    #[Id, Column(type: "uuid", unique: true)]
    #[GeneratedValue(strategy: "CUSTOM")]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name: 'name', type: 'string')]
    private string $name;

    #[Column(name: 'priv_level', type: 'integer')]
    private int $priv_level;

    #[OneToMany(targetEntity: User::class, mappedBy: 'group')]
    private Collection|null $users;

    #[OneToMany(targetEntity: Customer::class, mappedBy: 'group')]
    private Collection|null $customers;

    #[Column(name: 'created', type: 'datetime')]
    private DateTime $created;

    #[Column(name: 'updated', type: 'datetime')]
    private DateTime $updated;

    /**
     * Constructor method
     */
    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function __destruct() {}

    /**
     * Get the value of id
     */ 
    public function getId() : string
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */ 
    public function setName($name) : void
    {
        $this->name = $name;
    }

    /**
     * Get the value of priv_level
     */ 
    public function getPrivLevel() : int
    {
        return $this->priv_level;
    }

    /**
     * Set the value of priv_level
     */ 
    public function setPrivLevel(int $priv_level) : void
    {
        $this->priv_level = $priv_level;
    }

    /**
     * Get the value of users
     */ 
    public function getUsers() : Collection
    {
        return $this->users;
    }

    /**
     * Set the value of users
     */ 
    public function setUsers($users) : void
    {
        $this->users = $users;
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
    public function setUpdated()
    {
        $this->updated = new DateTime('now');
    }
}