<?php

/**
 * User Provider Interface.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 09/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\User;
use Ramsey\Uuid\Rfc4122\UuidInterface;

interface UserProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $uuid) : User;

    public function getByEmail(string $email) : User;

    public function update(UuidInterface $id, array $data) : void;

    public function delete(UuidInterface $id) : void;
}