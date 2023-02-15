<?php

/**
 * Ticket entity mapping.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Domain;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToOne;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

use DateTimeImmutable;

#[Entity, Table(name: 'tickets')]
class Ticket
{
    #[Id, Column(type: 'uuid', unique: true)]
    #[GeneratedValue(strategy: 'CUSTOM')]
    #[CustomIdGenerator(class: UuidGenerator::class)]
    private UuidInterface|string $id;

    #[Column(name:'subject', type:'string')]
    private string $subject;

    #[Column(name:'status', type:'integer')]
    private int $status;

    #[Column(name:'notes', type:'json')]
    private string $notes;

    #[Column(name: 'user')]
    #[ManyToOne(targetEntity: User::class, inversedBy: 'tickets')]
    private User|null $user;

    #[Column(name: 'customer')]
    #[ManyToOne(targetEntity: Customer::class, inversedBy: 'tickets')]
    private Customer|null $customer;

    #[Column(name: 'device')]
    #[OneToOne(targetEntity: Device::class, inversedBy: 'ticket')]
    private Device|null $device;

    #[Column(name:'created', type:'datetime')]
    private DateTimeImmutable $created;

    #[Column(name:'updated', type:'datetime')]
    private DateTimeImmutable $updated;

    public function __construct()
    {
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getId() : UuidInterface | string
    {
        return $this->id;
    }

    public function getSubject() : string
    {
        return $this->subject;
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    public function getNotes() : string
    {
        return $this->notes;
    }

    public function setNotes(string $notes)
    {
        
    }

    public function getUser() : User
    {
        return $this->user;
    }

    public function setUser(User $user) : void
    {
        $this->user = $user;
    }

    public function getCustomer() : Customer
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer) : void
    {
        $this->customer = $customer;
    }

    public function getDevice() : Device
    {
        return $this->device;
    }

    public function setDevice(Device $device) : void
    {
        $this->device = $device;
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