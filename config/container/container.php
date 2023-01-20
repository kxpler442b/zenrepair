<?php

/**
 * Build the container instance.
 * 
 * Author: B Moss
 * Email: <P2595849@my365.dmu.ac.uk>
 * Date: 15/01/23
 * 
 * @author B Moss
 */

declare(strict_types = 1);

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions(__DIR__ . '/container_bindings.php');

return $containerBuilder->build();