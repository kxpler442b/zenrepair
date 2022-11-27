<?php

/**
 * portalController.php
 * 
 * handles customer portal functionality
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

class PortalController extends Controller
{
    public function portal(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'portal_view.twig', [
            'css_path' => CSS_PATH,
            'assets_path' => ASSETS_PATH,
            'title' => 'Portal'
        ]);
    }
}