<?php

/**
 * Authentication provider contract.
 * 
 * @author Benjamin Moss <p2595849@my365.dmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Auth\Contract;

interface AuthProviderContract
{
    public function login(string $email, string $password): bool;

    public function verify(): bool;

    public function clear(): void;
}