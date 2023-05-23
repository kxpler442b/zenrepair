<?php

/**
 * Note entity mapping.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Domain;

use DateTime;
use App\Trait\EntityId;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\ManyToOne;

#[Entity, Table(name: 'notes')]
class Note
{
    use EntityId;

    #[Column(name: 'title', type: 'string')]
    private string $title;

    #[Column(name: 'content', type: 'string')]
    private string $content;

    #[ManyToOne(targetEntity: Ticket::class, inversedBy: 'notes')]
    private ?Ticket $ticket;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'notes')]
    private ?User $author;

    #[Column(name: 'created', type: 'datetime', updatable: false)]
    private DateTime $created;

    #[Column(name: 'updated', type: 'datetime')]
    private DateTime $updated;

    /**
     * Get the value of title
     */ 
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Get the value of content
     */ 
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @return  self
     */ 
    public function setContent(string $content = null): void
    {
        $this->content = $content;
    }

    /**
     * Get the value of ticket
     */ 
    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    /**
     * Set the value of ticket
     *
     * @return  self
     */ 
    public function setTicket(Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the value of author
     */ 
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @return  self
     */ 
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * Get the value of created
     */ 
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * Set the value of created
     *
     * @return  self
     */ 
    public function setCreated(): void
    {
        $this->created = new DateTime('now');
    }

    /**
     * Get the value of updated
     */ 
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * Set the value of updated
     *
     * @return  self
     */ 
    public function setUpdated(): void
    {
        $this->updated = new DateTime('now');
    }
}