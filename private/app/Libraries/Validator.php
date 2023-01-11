<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Libraries;

class Validator
{
    protected $container;
    protected $errors;

    public function __construct(\Psr\Container\ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function __destruct() {}

    public function validateLoginForm(string $email) : bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === True)
        {
            return True;
        } else {
            return False;
        }
    }
}