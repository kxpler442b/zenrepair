<?php

/**
 * Customer entity for Doctrine.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use DateTimeImmutable;

#[Entity, Table(name: 'customers')]
class Customer
{
    #[Id, Column(name: 'id', )]
    private int $id;

    #[Column(name:'email', type:'string')]
    private string $email;

    #[Column(name:'password', type:'string')]
    private string $password;

    #[Column(name: 'mobile', type: 'string')]
    private string $mobile;

    #[Column(name: 'alt_mobile', type: 'string')]
    private string $alt_mobile;

    #[Column(name: 'first_name', type: 'string')]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string')]
    private string $last_name;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct(string $email, string $password, string $first_name, string $last_name)
    {
        $this->email = $email;
        $this->password = $password;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getMobile() : string
    {
        return $this->mobile;
    }

    public function getAltMobile() : string
    {
        return $this->alt_mobile;
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function getLastName() : string
    {
        return $this->last_name;
    }

    public function getCreated() : DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated() : DateTimeImmutable
    {
        return $this->updated;
    }
}