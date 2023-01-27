<?php

/**
 * Base controller class.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AuthController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $twig_data = [
            'title' => 'Mega 3D World'
        ];

        return $this->render($response, '/home_view.twig', $twig_data);
    }
}