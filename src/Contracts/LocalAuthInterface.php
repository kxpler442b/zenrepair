<?php

/**
 * Authentication Provider Interface.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 09/02/23
 */

declare(strict_types = 1);

namespace App\Contracts;

use App\Domain\User;

interface LocalAuthInterface
{
    public function authUserByPassword(string $email, string $password);

    public function checkUserAuthStatus(User $user);
}