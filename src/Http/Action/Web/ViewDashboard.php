<?php

declare(strict_types = 1);

namespace App\Http\Action\Web;

use GuzzleHttp\Psr7\Response;

class ViewDashboard extends WebAction
{
    public function action(): Response
    {
        return $this->respondWithView('/base.html');
    }
}