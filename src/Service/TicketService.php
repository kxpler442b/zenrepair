<?php

/**
 * Ticket Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\Ticket;
use Doctrine\ORM\EntityManager;

class TicketService
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

    public function create(array $data): void
    {
        $ticket = new Ticket;

        $ticket->setTitle($data['title']);
        $ticket->setStatus($data['status'] ?? 0);
        $ticket->setUser($data['user']);
        $ticket->setDevice($data['device']);
        $ticket->setCreated();
        $ticket->setUpdated();
        
        $this->em->persist($ticket);
        $this->em->flush();

    }

    public function getById(string $id): Ticket
    {
        return $this->em->find(Ticket::class, $id);
    }

    public function getAll() : array
    {
        return $this->em->getRepository(Ticket::class)->findAll();
    }

    public function update(string $id, array $data): void
    {
        $ticket = $this->em->find(Ticket::class, $id);

        $ticket->setSubject($data['subject']);
    }

    public function delete(string $id): void
    {
        
    }
}