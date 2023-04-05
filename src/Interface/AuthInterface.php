<?php

/**
 * Authentication interface.
 * 
 * @author B Moss <p2595849@mydmu.ac.uk>
 * 
 * Date: 20/03/23
 */

declare(strict_types = 1);

namespace App\Interface;

interface AuthInterface
{
    public function authUser(): bool;

    public function authCustomer(): bool;

    public function authCheckpoint(): bool;

    public function deAuthUser(): void;

    public function deAuthCustomer(): void;
}