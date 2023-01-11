<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class TicketModel extends BaseModel
{
    public function createTicket()
    {

    }

    public function getTicket()
    {

    }

    public function getAllTickets() : array
    {
        $this->sql = 'SELECT * FROM zenrepair.tickets';

        $this->stmt = $this->database->prepareStatement($this->sql);
        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
    }

    public function updateTicket()
    {

    }

    public function deleteTicket()
    {

    }
}