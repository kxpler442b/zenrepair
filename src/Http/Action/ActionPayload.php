<?php

declare(strict_types = 1);

namespace App\Http\Action;

use JsonSerializable;

class ActionPayload implements JsonSerializable
{
    private int $statusCode;
    private $data;
    
    public function __construct(int $statusCode = 200, $data = null)
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getData()
    {
        return $this->data;
    }

    public function jsonSerialize(): array
    {
        $payload = [
            'statusCode' => $this->statusCode
        ];

        if($this->data != null) {
            $payload['data'] = $this->data;
        } elseif($this->data == null) {
            $payload['error'] = 'error';
        };

        return $payload;
    }
}