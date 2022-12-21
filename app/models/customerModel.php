<?php

/**
 * customerModel.php
 * 
 * To Do: Describe this controller and its functions.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 21/12/22
 * 
 * @author B Moss
 */

declare(strict_types=1);

namespace App\Models;

class CustomerModel extends BaseModel
{
    public function queryGetCustomer(string $id): array
    {
        $customer = [];

        $query = "/api/collections/customers/records/" . $id;
        $response = $this->pb->getFromApi($query);

        return $customer;
    }

    public function queryGetCustomers(): array
    {
        $customer = [];

        $query = "/api/collections/customers/records";
        $response = $this->pb->getFromApi($query);

        return $customer;
    }

    public function querySearchCustomer(array $args): array
    {
        $customer = [];

        $query = "/api/collections/customers/records";
        $response = $this->pb->getFromApi($query);

        return $customer;
    }
}