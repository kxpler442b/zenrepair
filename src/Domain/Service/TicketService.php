<?php

declare(strict_types = 1);

namespace App\Domain\Service;

use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManager;
use App\Domain\Entity\UserEntity;
use Odan\Session\SessionInterface;
use App\Domain\Entity\TicketEntity;
use App\Domain\XferObject\TicketObject;
use App\Domain\Repository\UserRepository;
use App\Domain\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Service for handling ticket CRUD actions.
 */
class TicketService
{
    private TicketRepository $tickets;
    private UserRepository $users;
    private SessionInterface $session;
    private LoggerInterface $logger;

    public function __construct(
        EntityManager $em,
        SessionInterface $session,
        LoggerInterface $logger
    ) {
        $this->tickets = $em->getRepository(TicketEntity::class);
        $this->users = $em->getRepository(UserEntity::class);
        $this->session = $session;
        $this->logger = $logger;
    }

    /**
     * Creates a new Ticket.
     *
     * @param TicketObject $ticketObject
     * 
     * @return self
     */
    public function createTicket(TicketObject $ticketObject): self
    {
        $authorId = base64_decode($this->session->get('zenrepair_user'));
        $author = $this->users->findOneBy(['id' => $authorId]);

        $ticket = $this->tickets->newTicket($ticketObject, $author);
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