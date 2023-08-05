<?php

declare(strict_types = 1);

namespace App\Auth\Interface;

interface LocalUserInterface
{
    public function getEmail(): string;

    public function setEmail(string $email);

    public function getPassword(): string;

    public function setPassword(string $password);
}