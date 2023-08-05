<?php

declare(strict_types = 1);

namespace App\Auth\Interface;

interface LocalUserRepositoryInterface
{
    public function getNewUser(array $credentials): LocalUserInterface;

    public function persistUser(LocalUserInterface $localUser): void;

    public function getUserByCredentials(array $credentials): ?LocalUserInterface;

    public function removeUser(LocalUserInterface $localUser): void;
}