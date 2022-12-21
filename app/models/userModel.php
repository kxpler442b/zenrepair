<?php

/**
 * userModel.php
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

class UserModel extends BaseModel
{
    /**
     * Returns user data in an array.
     *
     * @param string $id
     * @return array
     */
    public function queryGetUser(string $id): array
    {
        $customer = [];

        $query = "/api/collections/users/records/" . $id;
        $response = $this->pb->getFromApi($query);

        return $customer;
    }

    /**
     * Returns all user data in an array.
     *
     * @return array
     */
    public function queryGetUsers(): array
    {
        $customer = [];

        $query = "/api/collections/users/records";
        $response = $this->pb->getFromApi($query);

        return $customer;
    }

    /**
     * Undocumented function
     *
     * @param array $args
     * @return array
     */
    public function querySearchUser(array $args): array
    {
        $customer = [];

        $query = "/api/collections/users/records";
        $response = $this->pb->getFromApi($query);

        return $customer;
    }
}