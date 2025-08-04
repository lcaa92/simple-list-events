<?php

namespace controllers;

use services\DataService;

class EventsController
{

    public function index()
    {
        $srv = new DataService();
        echo json_encode($srv->getEvents());
    }
}