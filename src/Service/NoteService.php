<?php

/**
 * Note Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * 
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Service;

use App\Domain\Note;
use App\Domain\User;
use App\Domain\Ticket;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

class NoteService
{
    private readonly EntityManager $em;
    private ObjectRepository|EntityRepository $repo;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->getRepository();
    }

    /**
     * Creates a new Note.
     *
     * @param string $title
     * @param string $content
     * @param Ticket $ticket
     * @param User $user
     * 
     * @return void
     */
    public function create(string $title, string $content, Ticket $ticket, User $user): void
    {
        $note = new Note;

        $note->setTitle($title);
        $note->setContent($content);
        $note->setTicket($ticket);
        $note->setAuthor($user);
        $note->setUuid();
        $note->setCreated();
        $note->setUpdated();

        $this->em->persist($note);
        $this->em->flush();
    }

    /**
     * Returns a single Note object.
     *
     * @param string $uuid
     * 
     * @return Note|null
     */
    public function getSingle(string $uuid): ?Note
    {
        return $this->findByUuid($uuid);
    }

    /**
     * Returns all Notes in the database in an array.
     *
     * @return array|null
     */
    public function getAll(): ?array
    {
        return $this->repo->findAll();
    }

    public function update(string $uuid, array $content): void
    {

    }

    /**
     * Deletes a single Note object.
     *
     * @param string $uuid
     * 
     * @return void
     */
    public function delete(Note $note): void
    {
        $this->em->remove($note);
        $this->em->flush();
    }

    /**
     * Finds a note by its integer ID.
     *
     * @param integer $id
     * 
     * @return Note|null
     */
    private function findById(int $id): ?Note
    {
        return $this->repo->findOneBy(['id' => $id]);
    }

    /**
     * Finds a note by its Uuid.
     *
     * @param string $uuid
     * 
     * @return Note|null
     */
    private function findByUuid(string $uuid): ?Note
    {
        return $this->repo->findOneBy(['uuid' => $uuid]);
    }

    /**
     * Sets the entity repository.
     *
     * @return void
     */
    private function getRepository(): void
    {
        $this->repo = $this->em->getRepository(Note::class);
    }
}