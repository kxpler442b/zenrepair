<?php

/**
 * Dashboard controller.
 * 
 * @author B Moss <P2595849@mydmu.ac.uk>
 * Date: 02/01/23
 */

declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DashboardController extends Controller
{
    public function dashboardView(Request $request, Response $response)
    {
        $twig_data = [
            'css_path' => CSS_URI,
            'title' => 'Dashboard - RSMS'
        ];

        return $this->render($response, '/dashboard_view.twig', $twig_data);
    }
}