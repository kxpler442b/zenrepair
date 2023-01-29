<?php

/**
 * Ticket entity for Doctrine.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Entities;

use App\Entities\User;
use App\Entities\Customer;
use App\Entities\Device;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;
use DateTimeImmutable;

#[Entity, Table(name: 'tickets')]
class Ticket
{
    #[Id, Column(name: 'id'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(name:'subject', type:'string', nullable: false)]
    private string $subject;

    #[Column(name:'notes', type:'json')]
    private array $notes;

    #[Column(name: 'status', type: 'integer')]
    private int $status;

    #[ManyToOne(targetEntity: User::class)]
    private int $assoc_user;

    #[ManyToOne(targetEntity: Customer::class)]
    private int $assoc_customer;

    #[OneToOne(targetEntity: Device::class)]
    private int $assoc_device;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct(string $subject, int $status = 0)
    {
        $this->subject = $subject;
        $this->status = $status;
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function getNotes() : array
    {
        return $this->notes;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function getAssocUser() : int
    {
        return $this->assoc_user;
    }

    public function getFirstName() : int
    {
        return $this->assoc_customer;
    }

    public function getLastName() : int
    {
        return $this->assoc_device;
    }

    public function getCreated() : DateTimeImmutable
    {
        return $this->created;
    }

    public function getUpdated() : DateTimeImmutable
    {
        return $this->updated;
    }
}