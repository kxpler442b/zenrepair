<?php

/**
 * Address object model.
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
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Query\AST\UpdateItem;

#[Entity, Table(name: 'addresses')]
class Address
{
    use EntityId;

    #[Column(name: 'line_one', type: 'string')]
    private string $line_one;

    #[Column(name: 'line_two', nullable: true)]
    private string $line_two;

    #[Column(name: 'county', type: 'string')]
    private string $county;

    #[Column(name: 'town', type: 'string')]
    private string $town;

    #[Column(name: 'postcode', type: 'string')]
    private string $postcode;

    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'addresses')]
    private ?Customer $customer;

    #[Column(name:'created', type:'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTime $updated;

    /**
     * Get the value of line_one
     */ 
    public function getLineOne(): string
    {
        return $this->line_one;
    }

    /**
     * Set the value of line_one
     */ 
    public function setLineOne(string $line_one): void
    {
        $this->line_one = $line_one;
    }

    /**
     * Get the value of line_two
     */ 
    public function getLineTwo(): string
    {
        return $this->line_two;
    }

    /**
     * Set the value of line_two
     */ 
    public function setLineTwo(string $line_two): void
    {
        $this->line_two = $line_two;
    }

    /**
     * Get the value of county
     */ 
    public function getCounty(): string
    {
        return $this->county;
    }

    /**
     * Set the value of county
     */ 
    public function setCounty(string $county)
    {
        $this->county = $county;
    }

    /**
     * Get the value of town
     */ 
    public function getTown(): string
    {
        return $this->town;
    }

    /**
     * Set the value of town
     */ 
    public function setTown(string $town): void
    {
        $this->town = $town;
    }

    /**
     * Get the value of postcode
     */ 
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * Set the value of postcode
     */ 
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
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
    public function setCustomer(Customer $customer = null): void
    {
        $this->customer = $customer;
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