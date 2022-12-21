<?php

/**
 * model.php
 * 
 * To Do: Describe this controller and its functions.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 14/12/22
 * 
 * @author B Moss
 */

namespace App\Models;

use App\Pocketbase as Pocketbase;

abstract class BaseModel
{
    public function __construct() {
        $this->pb = new Pocketbase;
    }

    public function __destruct() {}
}