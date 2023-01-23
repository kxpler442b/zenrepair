<?php

/**
 * Homepage controller.
 * 
 * Author: B Moss
 * Date: 23/01/23
 * 
 * @author B Moss <p2595849@my365.dmu.ac.uk>
 */

declare(strict_types = 1);

namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller
{
    public function homeView(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_PATH,
            'js_path' => JS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Home - Zenrepair'
        ];

        return $this->render($response, '/app/home_view.twig', $twig_data);
    }
}