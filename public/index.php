<?php

/**
 * Application Single Point of Entry
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;

$container = require __DIR__ . '/../bootstrap.php';

$container->get(App::class)->run();