<?php

/**
 * Authentication service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Services;

use App\Controllers\AuthController;

class AuthService
{
    protected $controller;

    public function __construct(AuthController $controller)
    {
        $this->controller = $controller;
    }

    public function __destruct() {}

    public function getController() : AuthController
    {
        return $this->controller;
    }
}