<?php

namespace controllers;

use services\DataService;
use responses\Response;
use responses\SuccessResponse;
use responses\ErrorResponse;

class EventsController
{

    public function index(): Response
    {
        $srv = new DataService();
        $id = $_GET['id'] ?? null;
        $event = $srv->getEvents($id);
        if(!isset($event)){
            return new ErrorResponse("Event Not Found", 404);
        }
        return new SuccessResponse(json_encode($event));
    }
}