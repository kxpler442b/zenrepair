<?php

/**
 * Return an array containing the required dependencies.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use App\Config;
use Slim\Views\Twig;
use function DI\create;
use Doctrine\ORM\ORMSetup;
use Slim\Factory\AppFactory;
use \Doctrine\DBAL\Types\Type;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use SlimSession\Helper as SessionHelper;

use Psr\Http\Message\ResponseFactoryInterface;

return [
    App::class => function (ContainerInterface $container)
    {
        AppFactory::setContainer($container);

        $middleware = require CONFIG_PATH . '/middleware.php';
        $routes = require CONFIG_PATH . '/routes.php';

        $app = AppFactory::create();

        $routes($app);
        $middleware($app);

        return $app;
    },
    Config::class => create(Config::class)->constructor
    (
        require CONFIG_PATH . '/app.php',
    ),
    EntityManager::class => function (Config $config)
    {
        Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

        $orm_config = ORMSetup::createAttributeMetadataConfiguration(
            (array) $config->get('doctrine.entity_dir'),
            $config->get('doctrine.dev_mode')
        );

        $connection = DriverManager::getConnection($config->get('doctrine.connection'));

        return new EntityManager($connection, $orm_config);
    },
    Twig::class => function ()
    {
        $twig = Twig::create(VIEWS_PATH, [
            'debug' => true,
            'cache' => STORAGE_PATH . '/cache/twig',
            'auto_reload' => true
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        return $twig;
    },
    ResponseFactoryInterface::class => fn(App $app) => $app->getResponseFactory(),
    SessionHelper::class => function () {}
];