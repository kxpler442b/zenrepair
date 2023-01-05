<?php

/**
 * 
 */

declare (strict_types = 1);

namespace App\Libraries;

class Database
{
    protected $settings;
    protected $db;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __destruct() {}

    private function connect() : void
    {
        // Disconnect from MariaDB Instance
    }

    private function disconnect() : void
    {
        // Disconnect from MariaDB Instance
    }

    public function getConnection() : object
    {
        return $this->db;
    }

    public function getTop()
    {

    }

    public function getAll()
    {

    }

    public function create()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }
}