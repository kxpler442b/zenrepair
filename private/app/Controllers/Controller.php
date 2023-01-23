<?php

/**
 * Base controller class.
 * 
 * Author: B Moss
 * Date: 20/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Response;

abstract class Controller
{
    protected $container;

    /**
     * Constructor method.
     *
     * @param Container $container -> Slim's application container interface.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __destruct() {}

    /**
     * Returns a component from the Slim application container.
     *
     * @param string $component -> Name of the desired component.
     * @return mixed
     */
    public function __get(string $component)
    {
        return $this->container->get($component);
    }

    /**
     * Renders a twig template and returns the HTTP response.
     *
     * @param Response $response -> \Slim\Http\Response object.
     * @param string $twig_template -> The name of the twig template to use.
     * @param array $twig_data -> An array containing data used in rendering the specified template.
     * @return void
     */
    protected function render(Response $response, string $twig_template, array $twig_data = []) : void
    {
        $this->container->view->render($response, $twig_template, $twig_data);
    }
}