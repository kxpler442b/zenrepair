<?php

/**
 * Return an array containing the required dependencies.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use Slim\App;
use function DI\get;
use Slim\Views\Twig;
use App\Support\Config;
use function DI\create;
use App\Support\Session;
use App\Service\LocalAuthService;
use Doctrine\ORM\ORMSetup;
use Slim\Factory\AppFactory;
use \Doctrine\DBAL\Types\Type;
use App\Service\DeviceService;
use App\Service\TicketService;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use App\Interface\SessionInterface;
use App\Service\LocalAccountService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use App\Interface\LocalAccountProviderInterface;
use App\Interface\LocalAuthInterface;
use App\Service\AddressService;
use App\Service\CustomerService;

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
    LocalAccountProviderInterface::class => function(ContainerInterface $container)
    {
        return new LocalAccountService($container->get(EntityManager::class));
    },
    CustomerService::class => function(ContainerInterface $container)
    {
        return new CustomerService($container->get(EntityManager::class));
    },
    AddressService::class => function(ContainerInterface $container)
    {
        return new AddressService($container->get(EntityManager::class));
    },
    TicketService::class => function(ContainerInterface $container)
    {
        return new TicketService($container->get(EntityManager::class));
    },
    DeviceService::class => function(ContainerInterface $container)
    {
        return new DeviceService($container->get(EntityManager::class));
    },
    SessionInterface::class => function(Config $config)
    {
        return new Session($config->get('session'));
    },
    LocalAuthInterface::class => function(ContainerInterface $container)
    {
        return new LocalAuthService($container->get(LocalAccountService::class), $container->get(SessionInterface::class));
    },
];