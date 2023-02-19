<?php

/**
 * User group management service.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 19/02/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Domain\Group;
use Doctrine\ORM\EntityManager;

class GroupService
{
    private readonly EntityManager $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function __destruct() {}

    public function create(array $data) : void
    {
        $group = new Group();

        $group->setName($data['name']);
        $group->setPrivLevel($data['name'] ?? 2);
        $group->setCreated();
        $group->setUpdated();

        $this->em->persist($group);
        $this->em->flush();
    }

    public function getById(string $id) : Group
    {
        return $this->em->getRepository(Group::class)->findOneBy(['id' => $id]);
    }

    public function getByName(string $name) : Group
    {
        return $this->em->getRepository(Group::class)->findOneBy(['name' => $name]);
    }

    public function update(array $data) : void
    {

    }

    public function delete(string $id) : void
    {
        
    }
}