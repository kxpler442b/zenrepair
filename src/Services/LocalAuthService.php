<?php

/**
 * Authentication Service.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 11/02/23
 */

declare(strict_types = 1);

namespace App\Services;

class LocalAuthService
{
    public function __construct()
    {

    }

    public function authUserByPassword(string $email, string $password) : User | bool
    {

    }

    public function checkUserAuthStatus(string $id) : bool
    {

    }
}