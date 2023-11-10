<?php

namespace App\Test\Traits;

use Slim\App;
use DI\ContainerBuilder;
use Selective\TestTrait\Traits\HttpTestTrait;
use Selective\TestTrait\Traits\ArrayTestTrait;
use Selective\TestTrait\Traits\HttpJsonTestTrait;
use Selective\TestTrait\Traits\ContainerTestTrait;

trait AppTestTrait
{
    use ArrayTestTrait;
    use ContainerTestTrait;
    use HttpTestTrait;
    use HttpJsonTestTrait;

    protected App $app;

    /**
     * Before each test.
     */
    protected function setUp(): void
    {
        $this->setUpApp();
    }

    protected function setUpApp(): void
    {
        $container = (new ContainerBuilder())
            ->addDefinitions(__DIR__ . '/../../config/settings.php')
            ->addDefinitions(__DIR__ . '/../../config/container.php')
            ->build();

        $this->app = $container->get(App::class);

        $this->setUpContainer($container);
    }
}