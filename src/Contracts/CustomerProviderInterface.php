<?php

/**
 * Customer provider interface.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * 
 * Date: 15/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\Customer;
use Ramsey\Uuid\Rfc4122\UuidInterface;

interface CustomerProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $id) : Customer;

    public function getByEmail(string $email) : Customer;

    public function update(string $id, array $data) : void;

    public function delete(string $id) : void;
}