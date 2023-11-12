<?php

declare(strict_types = 1);

namespace App\Domain\XferObject;

class TicketObject
{
    public string $title;
    public int $status;

    public function __construct(
        string $title = 'Default Title',
        int $status = 0
    ) {
        $this->title = $title;
        $this->status = $status;
    }
}