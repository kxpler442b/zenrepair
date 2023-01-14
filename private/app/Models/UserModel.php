<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class UserModel extends BaseModel
{
    public function createUser()
    {

    }

    public function getUser(string $sanitised_email)
    {
        $this->sql = 'SELECT id, email, password, mobile_number, first_name, last_name, created, updated, is_admin
                        FROM zenrepair.users
                        WHERE email = :email';
        
        $this->stmt = $this->database->prepareStatement($this->sql);
        $this->stmt->bindParam(':email', $sanitised_email);
        $this->stmt->execute();

        $this->result = $this->database->fetchSingleRow($this->stmt);

        return $this->result;
    }

    public function getAllUsers(string $cols) : array
    {
        $this->sql = 'SELECT '.$cols.' FROM zenrepair.users';

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