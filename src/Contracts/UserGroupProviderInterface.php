<?php

/**
 * User group provider interface.
 * 
 * @author Benjamin Moss <p2595849@dmu.ac.uk>
 * 
 * Date: 24/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\Group;

interface UserGroupProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $id) : Group|null;

    public function getByName(string $name) : Group|null;

    public function update(array $data) : void;

    public function delete(string $id) : bool;
}