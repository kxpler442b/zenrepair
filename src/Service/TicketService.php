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
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class TicketService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->getRepository();
    }

    public function __destruct() {}

    public function create(array $data): void
    {
        $ticket = new Ticket;

        $ticket->setSubject($data['subject']);
        $ticket->setStatus($data['status'] ?? 0);
        $ticket->setUser($data['technician']);
        $ticket->setCustomer($data['customer']);
        $ticket->setDevice($data['device']);
        $ticket->setUuid();
        $ticket->setCreated();
        $ticket->setUpdated();
        
        $this->em->persist($ticket);
        $this->em->flush();

    }

    public function getById(string $id): ?Ticket
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    public function getByJobNumber(int $jobNumber): ?int
    {
        return $this->repo->findOneBy(['job_number' => $jobNumber]);
    }

    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    public function update(string $id, array $data): void
    {
        $ticket = $this->getById($id);

        $ticket->setSubject($data['subject']);
    }

    public function delete(string $id): void
    {
        
    }

    /**
     * Set the private repository object.
     *
     * @return void
     */
    private function getRepository(): void
    {
        $this->repo = $this->em->getRepository(Ticket::class);
    }
}