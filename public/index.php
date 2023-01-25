<?php

/**
 * Application Single Point of Entry
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

$app = require __DIR__ . '/../bootstrap.php';

require CONFIG_PATH . '/routes/routes.php';

$app->run();