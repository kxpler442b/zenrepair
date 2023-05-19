<?php

/**
 * Return an array containing the required dependencies.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

use App\Auth\Contract\AuthProviderContract;
use App\Auth\Provider\LocalAuthProvider;
use Slim\App;
use Slim\Views\Twig;
use App\Support\Config;
use function DI\create;
use App\Support\Session;
use Doctrine\ORM\ORMSetup;
use App\Service\UserService;
use Slim\Factory\AppFactory;
use \Doctrine\DBAL\Types\Type;
use App\Service\DeviceService;
use App\Service\TicketService;
use App\Service\AddressService;
use Doctrine\ORM\EntityManager;
use App\Service\CustomerService;
use App\Service\GuardianService;
use Doctrine\DBAL\DriverManager;
use App\Interface\SessionInterface;
use App\Interface\GuardianInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;

return [
    App::class => function (ContainerInterface $container)
    {
        AppFactory::setContainer($container);

        $middleware = require CONFIG_PATH . '/middleware.php';

        $authRoutes = require CONFIG_PATH . '/routes/auth.php';
        $workshopRoutes = require CONFIG_PATH . '/routes/workshop.php';
        $portalRoutes = require CONFIG_PATH . '/routes/portal.php';
        $restRoutes = require CONFIG_PATH . '/routes/rest.php';

        $app = AppFactory::create();

        $authRoutes($app);
        $workshopRoutes($app);
        $portalRoutes($app);
        $restRoutes($app);

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

    Twig::class => function (Config $config)
    {
        $twig = Twig::create(VIEWS_PATH, [
            'debug' => true,
            'cache' => STORAGE_PATH . '/cache/twig',
            'auto_reload' => true
        ]);

        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $twig->getEnvironment()->addGlobal(
            'globals', [
                'base_url' => BASE_URL,
                'favicon_url' => FAVICON_URL,
                'css_url' => CSS_URL,
                'assets_url' => ASSETS_URL,
                'icons_url' => ICONS_URL,
                'htmx_url' => HTMX_URL
            ]
        );
        
        return $twig;
    },

    ResponseFactoryInterface::class => fn(App $app) => $app->getResponseFactory(),

    UserService::class => function(ContainerInterface $container)
    {
        return new UserService($container->get(EntityManager::class));
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

    AuthProviderContract::class => function(ContainerInterface $c)
    {
        return new LocalAuthProvider($c->get(UserService::class), $c->get(SessionInterface::class));
    }
];