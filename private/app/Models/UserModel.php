<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class UserModel extends BaseModel
{
    protected $sql;
    protected $stmt;
    protected $result;

    public function createUser()
    {

    }

    public function getUser()
    {

    }

    public function getAllUsers() : array
    {
        $this->sql = 'SELECT * FROM users';

        $this->stmt = $this->database->prepareStatement($this->sql);
        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
    }

    public function updateUser()
    {

    }

    public function deleteUser()
    {

    }
}