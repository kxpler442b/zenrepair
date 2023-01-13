<?php

/**
 * 
 */

namespace App\Libraries;

class Crypto
{
    protected $database;
    protected $options;

    private $access_code;

    public function __construct(\App\Libraries\Database $database, array $options)
    {
        $this->database = $database;
        $this->options = $options;
    }

    public function __destruct() {}

    public function getAccessCode() : string
    {
        $this->generate_code();
        $access_code = password_hash($this->access_code, PASSWORD_BCRYPT, $this->options);

        return $access_code;
    }

    private function generate_code() : void
    {
        $this->access_code = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
    }
}