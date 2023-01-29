<?php

/**
 * User entity for Doctrine.
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

#[Entity, Table(name: 'users')]
class User
{
    #[Id, Column(name: 'id', )]
    private int $id;

    #[Column(name:'email', type:'string')]
    private string $email;

    #[Column(name:'token', type:'json')]
    private string $token;

    #[Column(name: 'mobile', type: 'string')]
    private string $mobile;

    #[Column(name: 'alt_mobile', type: 'string')]
    private string $alt_mobile;

    #[Column(name: 'first_name', type: 'string')]
    private string $first_name;

    #[Column(name: 'last_name', type: 'string')]
    private string $last_name;

    #[Column(name: 'is_admin', type: 'boolean')]
    private bool $is_admin;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct(string $email, string $first_name, string $last_name, bool $is_admin)
    {
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->is_admin = $is_admin;
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function getToken() : string
    {
        return $this->token;
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