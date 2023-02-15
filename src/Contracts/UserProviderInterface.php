<?php

/**
 * User Provider Interface.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 09/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use Ramsey\Uuid\Rfc4122\UuidInterface;

interface UserProviderInterface
{
    public function getById(UuidInterface $uuid);

    public function getByEmail(string $email);

    public function createUser(array $data);
}