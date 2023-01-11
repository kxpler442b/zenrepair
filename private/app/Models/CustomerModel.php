<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class CustomerModel extends BaseModel
{
    public function createCustomer(string $email, string $access_code, string $mobile_number, string $first_name, string $last_name)
    {
        $this->sql = 'INSERT INTO zenrepair.customers VALUES (:id, :email, :access_code, :mobile_number, :first_name, :last_name, :created, :updated)';

        $this->stmt = $this->database->prepareStatement($this->sql);

        $this->stmt->bindValue(':id', Null);
        $this->stmt->bindValue(':email', $email);
        $this->stmt->bindValue(':access_code', $access_code);
        $this->stmt->bindValue(':mobile_number', $mobile_number);
        $this->stmt->bindValue(':first_name', $first_name);
        $this->stmt->bindValue(':last_name', $last_name);
        $this->stmt->bindValue(':created', $this->getDate());
        $this->stmt->bindValue(':updated', $this->getDateTime());

        $this->result = $this->database->executeStatement($this->stmt);
    }

    public function getCustomer()
    {

    }

    public function getAllCustomers() : array
    {
        $this->sql = 'SELECT * FROM zenrepair.customers';

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