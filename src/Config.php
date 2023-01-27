<?php

/**
 * Adapted from https://github.com/ggelashvili/expennies
 */

declare(strict_types = 1);

namespace App;

class Config
{
    public function __construct(private readonly array $config) {}

    public function __destruct() {}

    public function get(string $name, mixed $default = Null) : mixed
    {
        $path = explode('.', $name);
        $value = $this->config[array_shift($path)] ?? Null;

        if ($value === Null)
        {
            return $default;
        }

        foreach ($path as $key)
        {
            if (!isset ($value[$key]))
            {
                return $default;
            }
            else
            {
                $value = $value[$key];
            }
        }

        return $value;
    }
}