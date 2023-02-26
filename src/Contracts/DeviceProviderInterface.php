<?php

/**
 * Customer provider interface.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 24/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\Device;

interface DeviceProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $id) : Device|null;

    public function getBySerial(string $id) : Device|null;

    public function getAll() : array;

    public function update(string $id, array $data) : void;

    public function delete(string $id) : void;
}