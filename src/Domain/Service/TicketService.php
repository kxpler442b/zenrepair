<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use Psr\Log\LoggerInterface;
use App\Domain\Entity\TicketEntity;
use App\Domain\Repository\TicketRepository;
use App\Domain\XferObject\TicketObject;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

/**
 * Service for handling ticket CRUD actions.
 */
class TicketService
{
    private TicketRepository $tickets;
    private LoggerInterface $logger;

    public function __construct(
        EntityManager $em,
        LoggerInterface $logger
    ) {
        $this->tickets = $em->getRepository(TicketRepository::class);
        $this->logger = $logger;
    }

    /**
     * Creates a new Ticket.
     *
     * @param TicketObject $ticketObject
     * 
     * @return self
     */
    public function newTicket(TicketObject $ticketObject): self
    {
        $ticket = $this->tickets->newTicket($ticketObject);
        $this->tickets->persistNewTicket($ticket);

        return $this;
    }

    /**
     * Returns a single ticket entity.
     *
     * @param string|null $id
     * @param TicketObject $ticketObject
     * 
     * @return TicketEntity|null
     */
    public function getTicket(string $id = null, TicketObject $ticketObject): ?TicketEntity
    {
        return null;
    }

    /**
     * Returns an ArrayCollection of ticket entities.
     *
     * @param integer $amount
     * 
     * @return ArrayCollection|null
     */
    public function getTickets(int $amount): ?ArrayCollection
    {
        return null;
    }

    /**
     * Updates a ticket.
     *
     * @param string|null $id
     * @param TicketObject $ticketObject
     * 
     * @return self
     */
    public function updateTicket(string $id = null, TicketObject $ticketObject): self
    {
        return $this;
    }

    /**
     * Deletes a ticket.
     *
     * @param string|null $id
     * @param TicketObject $ticketObject
     * 
     * @return self
     */
    public function deleteTicket(string $id = null, TicketObject $ticketObject): self
    {
        return $this;
    }
}