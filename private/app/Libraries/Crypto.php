<?php

/**
 * 
 */

namespace App\Libraries;

class Crypto
{
    protected $container;
    protected $options;

    public function __construct(\Psr\Container\ContainerInterface $container, array $options)
    {
        $this->container = $container;
        $this->options = $options;
    }

    public function __destruct() {}

    private static function generate_salt(int $len) : string
    {
        $
    }
}