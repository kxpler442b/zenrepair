<?php

/**
 * Entity ID trait for mapped Doctrine entities.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 07/03/23
 */

declare(strict_types = 1);

namespace App\Trait;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;

trait EntityId
{
    #[Id, Column(name: 'id', type: 'integer')]
    #[GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name: 'uuid', unique: true)]
    private ?UuidInterface  $uuid;

    /**
     * Get the primary database identity key.
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the secondary unique database identity key.
     *
     * @return UuidInterface|null
     */
    public function getUuid(): ?UuidInterface
    {
        return $this->uuid;
    }
}