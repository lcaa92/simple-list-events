<?php

namespace Controllers;

use Responses\SuccessResponse;

class HomeController
{
    public function index()
    {
        return new SuccessResponse(json_encode([
            'version' => '0.1.0'
        ]));
    }
}