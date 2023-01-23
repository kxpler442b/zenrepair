<?php

/**
 * User entity defenition.
 * 
 * Author: B Moss
 * Date: 20/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTimeImmutable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity, Table(name: 'users')]
final class User
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', unique: True, nullable: False)]
    private string $email;

    #[Column(type: 'string', unique: True, nullable: True)]
    private string $token;

    #[Column(type: 'string', unique: False, nullable: True)]
    private string $mobile;

    #[Column(type: 'string', unique: False, nullable: True)]
    private string $alt_mobile;

    #[Column(type: 'string', unique: False, nullable: True)]
    private string $first_name;

    #[Column(type: 'string', unique: False, nullable: True)]
    private string $last_name;
    
    #[Column(type: 'boolean', unique: False, nullable: True)]
    private string $is_admin;

    #[Column(type: 'datetimetz_immutable', nullable: False)]
    private DateTimeImmutable $created;

    #[Column(type: 'datetimetz_immutable', nullable: False)]
    private DateTimeImmutable $updated;

    public function __construct(string $email)
    {
        $this->email = $email;
        $this->created = new DateTimeImmutable('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function getMobileNumber() : string
    {
        return $this->mobile;
    }

    public function getAltMobileNumber() : string
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

    public function getIsAdmin() : bool
    {
        return $this->is_admin;
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