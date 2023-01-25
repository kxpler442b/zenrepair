<?php

/**
 * Home controller.
 * 
 * @author B Moss <P2595849@my365.dmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    public function homeView(Request $request, Response $response)
    {
        return $response->getBody()->write('Hello World!');
    }
}