<?php

/**
 * Define the User entity.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Entities;

use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'users')]
final class User
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private int $id;

    #[Column(type: 'string', unique: True, nullable: True)]
    private string $token;

    #[Column(type: 'string', unique: True, nullable: False)]
    private string $email;

    #[Column(type: 'string', nullable: True)]
    private string $mobile;

    #[Column(type: 'string', nullable: True)]
    private string $alt_mobile;

    #[Column(type: 'string', nullable: False)]
    private string $first_name;

    #[Column(type: 'string', nullable: False)]
    private string $last_name;

    #[Column(type: 'boolean', nullable: False)]
    private bool $is_admin;

    #[Column(name: 'created', type: 'datetimetz_immutable', nullable: False)]
    private DateTimeImmutable $created;

    #[Column(name: 'updated', type: 'datetimetz_immutable', nullable: False)]
    private DateTimeImmutable $updated;

    public function __construct(string $email, string $first_name, string $last_name, bool $is_admin)
    {
        $this->email = $email;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->is_admin = $is_admin;
        $this->created = new DateTimeImmutable('now');
        $this->updated = new DateTimeImmutable('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function getEmail() : string
    {
        return $this->email;
    }
}