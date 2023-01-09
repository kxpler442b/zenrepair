<?php

/**
 * 
 */

declare (strict_types = 1);

namespace App\Models;

abstract class BaseModel
{
    protected $database;

    public function __construct(\App\Libraries\Database $database)
    {
        $this->database = $database;
    }

    public function __destruct() {}
}