<?php

declare(strict_types = 1);

namespace App\Auth\Interface;

interface AuthInterface
{
    public function login(array $credentials);

    public function verify(array $credentials);

    public function logout();

    public function createUser(array $credentials);
}