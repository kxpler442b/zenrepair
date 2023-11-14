<?php

declare(strict_types = 1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Trait\HasUuidTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Domain\Repository\TicketRepository;
use App\Domain\Trait\HasCreatedUpdatedTrait;

#[Entity(repositoryClass: TicketRepository::class)]
#[Table(name: 'tickets')]
class TicketEntity
{
    use HasUuidTrait, HasCreatedUpdatedTrait;

    #[Column(type: 'string', length: 50)]
    private string $title;

    #[Column(type: 'integer')]
    private int $status;

    #[ManyToOne(targetEntity: UserEntity::class, inversedBy: 'tickets', cascade: ['PERSIST'])]
    private UserEntity $author;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status = 0): self
    {
        $this->status = $status;

        return $this;
    }
}