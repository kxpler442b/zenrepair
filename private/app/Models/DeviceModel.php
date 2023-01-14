<?php

/**
 * 
 */

declare(strict_types = 1);

namespace App\Models;

class DeviceModel extends BaseModel
{
    public function createdevice()
    {

    }

    public function getDevice(string $id)
    {
        $this->sql = 'SELECT * FROM zenrepair.devices WHERE (id = :id)';

        $this->stmt = $this->database->prepareStatement($this->sql);

        $this->stmt->bindValue(':id', $id);

        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
    }

    public function getAllDevices(string $cols) : array
    {
        $this->sql = 'SELECT '.$cols.' FROM zenrepair.devices ORDER BY updated DESC';

        $this->stmt = $this->database->prepareStatement($this->sql);
        $this->stmt->execute();

        $this->result = $this->database->fetchAllRows($this->stmt);

        return $this->result;
    }

    public function updateDevice()
    {

    }

    public function deleteDevice()
    {

    }
}