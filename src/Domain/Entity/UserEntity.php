<?php

declare(strict_types = 1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity()]
#[Table(name: 'users')]
class UserEntity
{
    #[Column(type: 'string', length: 24)]
    private string $username;

    #[Column(type: 'string')]
    private string $password_hash;

    #[Column(type: 'string')]
    private string $password_pepper;

    #[Column(type: 'string', length: 320, nullable: true)]
    private string $email;

    #[Column(type: 'string')]
    private string $given_name;

    #[Column(type: 'string', nullable: true)]
    private string $family_name;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPasswordHash(): string
    {
        return $this->password_hash;
    }

    public function setPasswordHash(string $password_hash): self
    {
        $this->password_hash = $password_hash;

        return $this;
    }

    public function getPasswordPepper(): string
    {
        return $this->password_pepper;
    }

    public function setPasswordPepper(string $password_pepper): self
    {
        $this->password_pepper = $password_pepper;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getGivenName(): string
    {
        return $this->given_name;
    }

    public function setGivenName(string $given_name): self
    {
        $this->given_name = $given_name;

        return $this;
    }

    public function getFamilyName(): string
    {
        return $this->family_name;
    }

    public function setFamilyName(string $family_name): self
    {
        $this->family_name = $family_name;

        return $this;
    }
}