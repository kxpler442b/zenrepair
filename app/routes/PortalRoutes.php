<?php

/**
 * PortalRoutes.php
 * 
 * To Do: Describe this PHP file.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 07/12/22
 * 
 * @author B Moss
 */

$app->get('/portal', \App\Controllers\PortalController::class . ':portal')->setname('portal');