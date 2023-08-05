<?php

declare(strict_types = 1);

namespace App\Domain\Entity;

use App\Domain\Trait\UuidTrait;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Trait\CreatedUpdatedTrait;
use App\Auth\Interface\LocalUserInterface;
use App\Domain\Repository\LocalUserRepository;

#[Entity(repositoryClass: LocalUserRepository::class)]
#[Table(name: 'localUsers')]
class LocalUserEntity implements LocalUserInterface
{
    use UuidTrait, CreatedUpdatedTrait;

    #[Column(type: 'string', unique: true)]
    private string $email;

    #[Column(type: 'string')]
    private string $password;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}