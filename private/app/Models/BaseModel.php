<?php

/**
 * 
 */

declare (strict_types = 1);

namespace App\Models;

abstract class BaseModel
{
    protected $database;

    protected $sql;
    protected $stmt;
    protected $result;

    public function __construct(\App\Libraries\Database $database)
    {
        $this->database = $database;
    }

    public function __destruct() {}

    public function getDate() : string
    {
        return date('Y-m-d');
    }

    public function getDateTime() : string
    {
        return date('Y-m-d G:i:s');
    }
}