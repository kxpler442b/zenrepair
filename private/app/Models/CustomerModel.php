<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class CustomerModel extends BaseModel
{
    protected $sql;
    protected $stmt;
    protected $result;

    public function createCustomer()
    {

    }

    public function getCustomer()
    {

    }

    public function getAllCustomers() : array
    {
        $this->sql = 'SELECT * FROM customers';

        $this->stmt = $this->database->prepareStatement($this->sql);
        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
    }

    public function updateCustomer()
    {

    }

    public function deleteCustomer()
    {

    }
}