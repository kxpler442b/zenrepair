<?php

declare(strict_types = 1);

namespace App\Domain\Repository;

use Carbon\Carbon;
use Doctrine\ORM\EntityRepository;
use App\Domain\Entity\TicketEntity;
use App\Domain\Entity\UserEntity;
use App\Domain\XferObject\TicketObject;

/**
 * Repository for handling ticket entities.
 */
class TicketRepository extends EntityRepository
{
    /**
     * Creates and returns a new ticket entity.
     *
     * @param TicketObject $ticketObject
     * 
     * @return TicketEntity
     */
    public function newTicket(TicketObject $ticketObject, UserEntity $author): TicketEntity
    {
        $dt = new Carbon('now');

        return (new TicketEntity())
            ->setTitle($ticketObject->title)
            ->setStatus($ticketObject->status)
            ->setAuthor($author)
            ->setCreated($dt)
            ->setUpdated($dt);
    }

    /**
     * Persists the given ticket entity and flushes the Entity Manager.
     *
     * @param TicketEntity $ticket
     * 
     * @return self
     */
    public function persistNewTicket(TicketEntity $ticket): self
    {
        $this->_em->persist($ticket);
        $this->_em->flush();

        return $this;
    }
}