<?php

/**
 * Tickets Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Domain\Ticket;
use Doctrine\ORM\EntityManager;

class TicketService
{
    private readonly EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __destruct() {}

    public function create(string $subject)
    {
        $ticket = new Ticket();

        $ticket->setSubject($subject);
    }

    public function getTicketById(string $id)
    {
        $this->entityManager->find(Ticket::class, $id);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}