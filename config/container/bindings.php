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
use App\Session;
use App\LocalAuth;
use function DI\get;
use Slim\Views\Twig;
use function DI\create;
use Doctrine\ORM\ORMSetup;
use Slim\Factory\AppFactory;
use App\Services\UserService;
use \Doctrine\DBAL\Types\Type;
use App\Services\GroupService;
use App\Services\DeviceService;
use Doctrine\ORM\EntityManager;
use App\Contracts\AuthInterface;
use Doctrine\DBAL\DriverManager;
use App\Services\CustomerService;
use App\Services\LocalAuthService;
use App\Contracts\SessionInterface;
use Psr\Container\ContainerInterface;
use App\Contracts\UserProviderInterface;
use App\Contracts\DeviceProviderInterface;
use App\Contracts\TicketProviderInterface;
use App\Contracts\CustomerProviderInterface;
use App\Contracts\UserGroupProviderInterface;
use App\Services\TicketService;
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
    UserProviderInterface::class => function(ContainerInterface $container)
    {
        return new UserService($container->get(EntityManager::class));
    },
    UserGroupProviderInterface::class => function(ContainerInterface $container)
    {
        return new GroupService($container->get(EntityManager::class));
    },
    CustomerProviderInterface::class => function(ContainerInterface $container)
    {
        return new CustomerService($container->get(EntityManager::class));
    },
    DeviceProviderInterface::class => function(ContainerInterface $container)
    {
        return new DeviceService($container->get(EntityManager::class));
    },
    TicketProviderInterface::class => function(ContainerInterface $container)
    {
        return new TicketService($container->get(EntityManager::class));
    },
    SessionInterface::class => function(Config $config)
    {
        return new Session($config->get('session'));
    },
    AuthInterface::class => function(ContainerInterface $container)
    {
        return new LocalAuth($container->get(UserProviderInterface::class), $container->get(SessionInterface::class));
    },
];