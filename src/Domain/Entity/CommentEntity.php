<?php

declare(strict_types = 1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Trait\HasUuidTrait;
use Doctrine\ORM\Mapping\ManyToOne;
use App\Domain\Trait\HasCreatedUpdatedTrait;

#[Entity()]
#[Table(name: 'comments')]
class CommentEntity
{
    use HasUuidTrait, HasCreatedUpdatedTrait;

    #[Column(type: 'string', length: 250)]
    private string $comment;

    #[ManyToOne(targetEntity: UserEntity::class, inversedBy: 'comments')]
    private UserEntity $author;

    #[ManyToOne(targetEntity: TicketEntity::class, inversedBy: 'comments')]
    private TicketEntity $ticket;
}