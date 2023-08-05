<?php

declare(strict_types = 1);

namespace App\Domain\Trait;

use Doctrine\ORM\Mapping\Id;
use Ramsey\Uuid\UuidInterface;
use Doctrine\ORM\Mapping\Column;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\CustomIdGenerator;

trait UuidTrait
{
    #[Id]
    #[Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface $id;

    /**
     * Get the entity identifier.
     *
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }
}