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

interface UserProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $uuid) : User|null;

    public function getByEmail(string $email) : User|null;

    public function update(string $id, array $data) : void;

    public function delete(string $id) : void;
}