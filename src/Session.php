<?php

/**
 * Session Middleware.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 15/02/23
 */

declare(strict_types = 1);

namespace App;

use App\Contracts\SessionInterface;
use App\Exception\SessionException;

class Session implements SessionInterface
{
    private readonly array $params;

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __destruct() {}

    public function start() : void
    {
        if($this->isActive())
        {
            throw new SessionException('A session is already active.');
        }

        if(headers_sent($file, $line))
        {
            throw new SessionException('Headers have already been sent.');
        }

        session_set_cookie_params([
            'secure' => $this->params['secure'] ?? true,
            'httponly' => $this->params['httponly'] ?? true,
            'samesite' => $this->params['samesite'] ?? 'lax'
        ]);

        session_start();
    }

    public function save() : void
    {
        session_write_close();
    }

    public function isActive() : bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    public function get(string $key, mixed $default = 'null') : mixed
    {
        return $_SESSION[$key];
    }

    public function regenerate() : bool
    {
        return session_regenerate_id();
    }

    public function store(string $key, mixed $value) : void
    {
        $_SESSION[$key] = $value;
    }

    public function exists(string $key) : bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function delete(string $key) : void
    {
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        session_destroy();
    }
}