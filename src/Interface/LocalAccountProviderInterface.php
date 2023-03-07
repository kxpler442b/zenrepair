<?php

/**
 * Local Account Provider Interface.
 * 
 * @author Benjamin Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 27/02/23
 */

declare(strict_types = 1);

namespace App\Interface;

use App\Domain\User;
use App\Domain\Group;

interface LocalAccountProviderInterface
{
    public function createAccount(array $data): void;

    public function createGroup(array $data): void;

    public function getAccountByUuid(string $uuid): ?User;

    public function getAccountByEmail(string $email): ?User;

    public function getAccountByGroup(string $group_id): ?User;

    public function getAccountsInGroup(string $group_name): ?array;

    public function getGroupById(string $id): ?Group;

    public function getGroupByName(string $name): ?Group;

    public function updateAccount(string $id, array $data): void;

    public function deleteAccount(string $id): void;
}