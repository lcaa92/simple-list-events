<?php

namespace controllers;

class HomeController
{
    public function index()
    {
        echo json_encode([
            'version' => '0.1.0'
        ]);
    }
}