<?php

/**
 * 
 * 
 * Author: B Moss
 * Email: <P2595849@my365.dmu.ac.uk>
 * Date: 17/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

namespace App\Entities;

use Doctrine\ORM;
use Doctrine\ORM\Mapping\Entity;

# [Entity, Table(name: 'users')];
final class User
{
    # [Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    # [Column(type: 'string', unique: true, nullable: false)]
    private string $email_address;

    
}