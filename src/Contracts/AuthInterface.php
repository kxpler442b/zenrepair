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

interface AuthInterface
{
    public function verify() : bool;

    public function attemptAuth(string $email, string $password) : bool;

    public function auth(User $user) : void;

    public function getUser() : User|null;

    public function checkPassword(string $password, string $hash) : bool;

    public function deauth() : void;
}