<?php

// bootstrap.php

use Slim\Container;

require_once __DIR__ . '/../../vendor/autoload.php';

$container = new Container(require __DIR__ . '/settings.php');

$container[\Doctrine\ORM\EntityManager::class] = function ($container): \Doctrine\ORM\EntityManager {
    $settings = $container->get('settings');

    $config = \Doctrine\ORM\ORMSetup::createAttributeMetadataConfiguration($settings['doctrine']['metadata_dirs'], $settings['doctrine']['dev_mode']);
    
    $connection = \Doctrine\DBAL\DriverManager::getConnection($settings['doctrine']['connection'], $config);

    return new \Doctrine\ORM\EntityManager($connection, $config);
};

return $container;