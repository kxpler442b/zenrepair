<?php

/**
 * dashController.php
 * 
 * handles dashboard endpoint and functionality
 * 
 * Author: B Moss
 * Email: P2595849@my365.dmu.ac.uk
 * Date: 26/11/22
 * 
 * @author B Moss
 */

declare(strict_types=1);

namespace App\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class DashController extends Controller
{
    public function dashboard(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'dash_view.twig', [
            'css_path' => CSS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Dashboard',
            'name' => 'Bob'
        ]);
    }
}