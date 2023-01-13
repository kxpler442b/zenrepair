<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class CustomerModel extends BaseModel
{
    private $access_code;

    public function createCustomer(array $data) : void
    {
        $this->access_code = $this->database->crypt->getAccessCode();

        $this->sql = 'INSERT INTO zenrepair.customers VALUES (:id, :email_address, :mobile_number, :first_name, :last_name, :access_code, :created, :updated)';

        $this->stmt = $this->database->prepareStatement($this->sql);

        $this->stmt->bindValue(':id', uniqid());
        $this->stmt->bindValue(':email_address', $data['email_address']);
        $this->stmt->bindValue(':mobile_number', $data['mobile_number']);
        $this->stmt->bindValue(':first_name', $data['first_name']);
        $this->stmt->bindValue(':last_name', $data['last_name']);
        $this->stmt->bindValue(':access_code', $this->access_code);
        $this->stmt->bindValue(':created', $this->getDate());
        $this->stmt->bindValue(':updated', $this->getDateTime());

        $this->result = $this->database->executeStatement($this->stmt);
    }

    public function getCustomer(string $id)
    {
        $this->sql = 'SELECT * FROM zenrepair.customers WHERE (id = :id)';

        $this->stmt = $this->database->prepareStatement($this->sql);

        $this->stmt->bindValue(':id', $id);

        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
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