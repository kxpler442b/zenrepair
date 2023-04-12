<?php

declare(strict_types = 1);

namespace App\Interface;

interface GuardianInterface
{
    public function authenticate(string $email, string $password): bool;

    public function verify(): bool;

    public function deauthenticate(): void;
}