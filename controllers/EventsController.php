<?php

namespace controllers;

use services\DataService;

class EventsController
{

    public function index(int $id = null)
    {
        $srv = new DataService();
        $event = $srv->getEvents($id);
        if(!isset($event)){
            header("HTTP/1.0 404 Not Found");
            echo "404 - Event Not Found";
            return;
        }
        echo json_encode($event);
    }
}