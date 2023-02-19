<?php

/**
 * Session Middleware.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 15/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Config;
use App\Exception\SessionException;

class SessionMiddleware implements SessionInterface
{
    private readonly array $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __destruct() {}

    public function start() : void
    {
        if ($this->isActive())
        {
            throw new SessionException('Session already exists.');
        }
        else
        {
            
        }
    }
}