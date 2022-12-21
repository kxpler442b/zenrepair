<?php

/**
 * ticketModel.php
 * 
 * To Do: Describe this controller and its functions.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 14/12/22
 * 
 * @author B Moss
 */

declare(strict_types=1);

namespace App\Models;

class TicketModel extends BaseModel
{
    /**
     * Returns an array containg the data from the specified ticket.
     *
     * @param string $id
     * @return array
     */
    public function queryGetTicket(string $id): array
    {
        $ticket = [];

        $query = "/api/collections/tickets/records/" . $id;
        $response = $this->pb->getFromApi($query);

        $ticket = [
            'id' => $response->id,
            'subject' => $response->subject,
            'customer' => $response->customer,
            'device' => $response->device,
            'status' => $response->status,
            'created' => $response->created,
            'updated' => $response->updated
        ];

        return $ticket;
    }

    /**
     * Returns all tickets in an array.
     *
     * @param string $id
     * @return array
     */
    public function queryGetTicketsByUser(string $id): array
    {
        $tickets = [];

        $query = "/api/collections/tickets/records?filter=(technician='" . $id . "')";
        $response = $this->pb->getFromApi($query);

        foreach($response->items as &$item) {
            $ticket = [
                'id' => $item->id,
                'subject' => $item->subject,
                'customer' => $item->customer,
                'device' => $item->device,
                'status' => $item->status,
                'created' => $item->created,
                'updated' => $item->updated
            ];
            array_push($tickets, $ticket);
        }

        return $tickets;
    }

    /**
     * Searches for a ticket using the given critera, returns ticket in an array.
     *
     * @param string $query
     * @return array
     */
    public function querySearchTickets(string $query): array
    {
        $ticket = [];

        // To Do: Make a function for searching tickets.

        return $ticket;
    }
}