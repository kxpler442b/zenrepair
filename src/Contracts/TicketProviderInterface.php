<?php

/**
 * Ticket service interface.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 25/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\Ticket;
use Doctrine\Common\Collections\Collection;

interface TicketProviderInterface
{
    public function create(array $data) : void;

    public function getById(string $id) : Ticket|null;

    public function getAll() : array;

    public function update(string $id, array $data) : void;

    public function delete(string $id) : void;
}