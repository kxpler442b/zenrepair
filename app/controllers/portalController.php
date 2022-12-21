<?php

/**
 * PortalController.php
 * 
 * To Do: Describe this controller and its functions.
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 07/12/22
 * 
 * @author B Moss
 */

namespace App\Controllers;

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;

use Psr\Container\ContainerInterface as ContainerInterface;

class PortalController
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('view');
    }

    public function __destruct() {}

    public function portal(Request $request, Response $response)
    {
        /**
         * /portal
         * 
         * To Do: Describe this endpoint and its functions.
         */

        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Customer Portal'
        ];

        return $this->view->render($response, '/portal/portal_view.twig', $twig_data);
    }
}